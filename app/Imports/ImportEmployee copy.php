<?php

namespace App\Imports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing;

class ImportEmployee implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        //printed all data
        // echo "<pre>";
        // print_r($row);
        // echo "<pre>";

        // //inerted all data into database without image
        // return new Employee([
        //     'bp_no' => $row['bp_no'],
        //     'evsjv' => $row['evsjv'],
        //     'name' => $row['name'],
        //     'rank' => $row['rank'],
        //     'division' => $row['division'],
        // ]);

        $spreadsheet = IOFactory::load(request()->file('excel_file'));
        $i = 0;
        foreach ($spreadsheet->getActiveSheet()->getDrawingCollection() as $drawing) {
            $zipReader = fopen($drawing->getPath(), 'r');
            $imageContents = '';
            while (!feof($zipReader)) {
                $imageContents .= fread($zipReader, 1024);
            }
            fclose($zipReader);
            $extension = $drawing->getExtension();

        // $path = public_path('employees'); // Change this to your desired folder
        // if (!file_exists($path)) {
        //     mkdir($path, 0755, true);
        // }
        // $fullPath = $path . '/' . $myFileName;
        // file_put_contents($fullPath, $imageContents);

        $myFileName = 'Image_' . ++$i . '.' . 'png';
        // $myFileName = $row['serial_no']. '_1' . '.png';
        file_put_contents('employees/' . $myFileName, $imageContents);

        $employee = Employee::create([
            'bp_no' => $row['bp_no'],
            'evsjv' => $row['evsjv'],
            'name' => $row['name'],
            'rank' => $row['rank'],
            'division' => $row['division'],
            'picture' => $myFileName,

        ]);

        return $employee;

    }

        // echo "<pre>";
        // print_r($myFileName);
        // echo "<pre>";


        //inerted all data into database without image
        //   return new Employee([
        //     'bp_no' => $row['bp_no'],
        //     'evsjv' => $row['evsjv'],
        //     'name' => $row['name'],
        //     'rank' => $row['rank'],
        //     'division' => $row['division'],
        // ]);

    }

    private function uploadImage($base64Image)
    {
        $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64Image));
        $fileName = time() . '_' . uniqid() . '.png'; // You can modify the filename logic as needed
        $path = public_path('employees'); // Change this to your desired folder

        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }

        $fullPath = $path . '/' . $fileName;
        file_put_contents($fullPath, $imageData);

        return 'employees/' . $fileName; // Assuming the images folder is in your public directory
    }
}
