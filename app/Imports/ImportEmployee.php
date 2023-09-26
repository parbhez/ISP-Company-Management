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
        $spreadsheet = IOFactory::load(request()->file('excel_file'));
        $i = 0;
        $myFileName = "";
        $fileName = [];
        foreach ($spreadsheet->getActiveSheet()->getDrawingCollection() as $drawing) {
            if ($drawing instanceof MemoryDrawing) {
                ob_start();
                call_user_func(
                    $drawing->getRenderingFunction(),
                    $drawing->getImageResource()
                );
                $imageContents = ob_get_contents();
                ob_end_clean();
                switch ($drawing->getMimeType()) {
                    case MemoryDrawing::MIMETYPE_PNG:
                        $extension = 'png';
                        break;
                    case MemoryDrawing::MIMETYPE_GIF:
                        $extension = 'gif';
                        break;
                    case MemoryDrawing::MIMETYPE_JPEG:
                        $extension = 'jpg';
                        break;
                }
            } else {
                $zipReader = fopen($drawing->getPath(), 'r');
                $imageContents = '';
                while (!feof($zipReader)) {
                    $imageContents .= fread($zipReader, 1024);
                }
                fclose($zipReader);
                $extension = $drawing->getExtension();
            }

            $myFileName = time() . ++$i . '.' . $extension;
           // $myFileName = $row['serial_no']. '_1' . '.png';
            file_put_contents('employees/' . $myFileName, $imageContents);
            $fileName[] = $myFileName;
        }

        $employee = Employee::insert([
            'bp_no' => $row['bp_no'],
            'evsjv' => $row['evsjv'],
            'name' => $row['name'],
            'rank' => $row['rank'],
            'division' => $row['division'],
            'picture' => $fileName[$row['serial_no'] - 1],
        ]);



        // echo "<pre>";
        // echo $myFileName;
        // echo "<pre>";
        // print_r($row);
        // exit();

        // // Handle image upload and get the image path
        // $photoPath = $this->uploadImage($row['photo_path']);

        // return new Employee([
        //     'name' => $row['name'],
        //     'age' => $row['age'],
        //     'photo_path' => $photoPath
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
