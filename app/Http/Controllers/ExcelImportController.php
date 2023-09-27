<?php

namespace App\Http\Controllers;

use App\Imports\ImportEmployee;
use App\Models\Employee;
use App\Models\Police;
use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ExcelImportController extends Controller
{
    public function importdata()
    {
        return view('import');
    }


    public function DataPushInDevice()
    {
        try {
            $polices = Police::take(2)->get();
            $i = 0;

            foreach ($polices as $key => $row) {
                // 1st step
                $command1 = [
                    'serial' => 'ZZXQG2328440000000',
                    'name' => 'setusername',
                    'content' => '{"cmd":"setusername","count":1,"record":[{"enrollid":' . $row->id . ',"name":"' . $row->name . '"}]}',
                    'status' => 0,
                    'send_status' => 0,
                    'err_count' => 0,
                    'gmt_crate' => now(),
                    'gmt_modified' => now(),
                ];

                DB::connection('mysql_second')->table('machine_command')->insert($command1);

                // 2nd step
                if (isset($row->picture) && !empty($row->picture)) {
                    $filename = 'polices/' . $row->id . '_1.png';
                    if (file_exists($filename)) {
                        $data = file_get_contents($filename);
                        $img = base64_encode($data);
                    } else {
                        $img = "";
                    }

                    $command2 = [
                        'serial' => 'ZZXQG232844000000000',
                        'gmt_crate' => now(),
                        'gmt_modified' => now(),
                        'name' => 'setuserinfo',
                        'content' => '{"cmd":"setuserinfo","enrollid":' . $row->id . ',"name":"' . $row->name . '","backupnum":50,"admin":0,"record":"' . $img . '"}',
                    ];

                    DB::connection('mysql_second')->table('machine_command')->insert($command2);
                }

                $i++;
            }

            if ($i > 0) {
                echo "Total Store Student = " . $i;
            } else {
                echo "NO";
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }




    // public function DataPushInDevice()
    // {
    //     // return $baseUrl = url('/').'/'.'polices/15_1.png';
    //     $polices = Police::take(2)->get();

    //     $i = 0;
    //     foreach ($polices as $key => $row) {
    //         //1st step
    //         $command['serial'] = 'ZZXQG2328440000000';
    //         $command['name'] = 'setusername';
    //         $command['content'] = '{"cmd":"setusername","count":1,"record":[{"enrollid":' . $row->id . ',"name":"' . $row->name . '"}]}';
    //         $command['status'] = 0;
    //         $command['send_status'] = 0;
    //         $command['err_count'] = 0;
    //         $command['gmt_crate'] = date('Y-m-d H:i:s');
    //         $command['gmt_modified'] = date('Y-m-d H:i:s');
    //         DB::connection('mysql_second')->table('machine_command')->insert($command);


    //         // //2nd step
    //         if (isset($row->picture) && !empty($row->picture)) {
    //             $file_tmp = url('/').'/'. "polices/" . $row->picture;
    //             $data = file_get_contents($file_tmp);
    //             $img = base64_encode($data);
    //             $command['serial'] = 'ZZXQG232844000000000';
    //             $command['name'] = 'setuserinfo';
    //             $command['content'] = '{"cmd":"setuserinfo","enrollid":' . $row->id . ',"name":"' . $row->name . '","backupnum":50,"admin":0,"record":"' . $img . '"}';
    //             DB::connection('mysql_second')->table('machine_command')->insert($command);
    //         }
    //         $i++;
    //     }

    //     if ($i > 0) {
    //         echo "Total Store Student = " . $i;
    //     } else {
    //         echo "NO";
    //     }
    // }
    public function storeImportData(Request $request)
    {
        $file = $request->file('excel_file');

        // Ensure the file is an Excel file
        if (!in_array($file->getClientOriginalExtension(), ['xlsx', 'xls'])) {
            return redirect()->back()->with('error', 'Please upload a valid Excel file.');
        }

        try {
            // Initially Clear the Employee table
            Employee::truncate();

            // Load the Excel file
            $spreadsheet = IOFactory::load($file);

            $imageFilenames = [];
            $maxId = Police::max('id') ?? 0;

            foreach ($spreadsheet->getActiveSheet()->getDrawingCollection() as $i => $drawing) {
                $zipReader = fopen($drawing->getPath(), 'r');
                $imageContents = '';
                while (!feof($zipReader)) {
                    $imageContents .= fread($zipReader, 1024);
                }
                fclose($zipReader);
                $extension = $drawing->getExtension();

                $sumOfIds = $maxId + $i + 1; // Adjusted to start from $maxId + 1
                // $myFileName = $sumOfIds . '_1.' . $extension;
                $myFileName = $sumOfIds . '_1.' . 'png';

                $path = public_path('employees'); //create employees

                if (!file_exists($path)) {
                    mkdir($path, 0755, true);
                }

                file_put_contents(public_path('employees/' . $myFileName), $imageContents);
                $imageFilenames[] = $myFileName;
            }

            // Import the data using the specified importer class
            Excel::import(new ImportEmployee, $file);

            // Update Employee model with the image filenames
            foreach ($imageFilenames as $index => $filename) {
                $employee = Employee::find($index + 1);
                if ($employee) {
                    $employee->update(['picture' => $filename]);
                    Police::create([
                        'bp_no' => $employee->bp_no,
                        'evsjv' => $employee->evsjv,
                        'name' => $employee->name,
                        'rank' => $employee->rank,
                        'division' => $employee->division,
                        'picture' => $employee->picture,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            // Move files to the police folder
            $this->moveFilesToPoliceFolder($imageFilenames);

            // Clear the Employee table after processing
            Employee::truncate();

            return response()->json(['message' => 'Success', 'imageFilenames' => $imageFilenames], 200);
        } catch (Exception $e) {
            // Delete files in the specified folder
            $this->removeFilesInEmployeesFolder($imageFilenames);
            // Rollback the transaction on any exception
            return response()->json(['message' => "Failed", 'error' => $e->getMessage()], 500);
        }
    }

    public function moveFilesToPoliceFolder($imageFilenames)
    {
        foreach ($imageFilenames as $filename) {
            $sourcePath = public_path('employees/' . $filename);

            $path = public_path('polices'); // Change this to your desired folder

            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }

            $destinationPath = public_path('polices/' . $filename);

            // Check if the source file exists
            if (file_exists($sourcePath)) {
                // Move the file to the police folder
                rename($sourcePath, $destinationPath);
            }
        }
    }

    public function removeFilesInEmployeesFolder()
    {
        $employeesFolderPath = public_path('employees');

        // Check if the directory exists
        if (File::isDirectory($employeesFolderPath)) {
            // Get all files in the directory
            $files = File::allFiles($employeesFolderPath);

            // Iterate through each file and delete it
            foreach ($files as $file) {
                File::delete($file->getPathname());
            }
        }
    }
}
