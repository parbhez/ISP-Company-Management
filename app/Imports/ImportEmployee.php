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

       // printed all data
        // echo "<pre>";
        // print_r($row);
        // echo "<pre>";

        //inerted all data into database without image
        return new Employee([
            'employee_name' => $row['employee_name'] ?? 'null',
            'employee_phone' => $row['employee_phone'] ?? 'null',
            'employee_address' => $row['employee_address'] ?? 'null',
            'employee_post' => $row['employee_post'] ?? 'null',
            'employee_access' => $row['employee_access'] ?? '["5","6"]',
            'employee_status' => $row['employee_status'] ?? '1',
            'employee_rfid' => $row['employee_rfid'] ?? 'null',
            'user_id' => $row['user_id'] ?? 2,
            'emp_id' => $row['emp_id'] ?? 'null',
        ]);

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
