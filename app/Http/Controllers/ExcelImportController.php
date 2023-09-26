<?php

namespace App\Http\Controllers;

use App\Imports\ImportEmployee;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


class ExcelImportController extends Controller
{
    public function importdata()
    {
        return view('import');
    }

    public function storeImportData(Request $request)
    {
        $file = $request->file('excel_file');

        // Ensure the file is an Excel file
        if ($file->getClientOriginalExtension() !== 'xlsx' && $file->getClientOriginalExtension() !== 'xls') {
            return redirect()->back()->with('error', 'Please upload a valid Excel file.');
        }

        try {
            // Import the data using the specified importer class
            Excel::import(new ImportEmployee, request()->file('excel_file'));

            echo "Data imported successfully.";

            //return redirect()->back()->with('success', 'Data imported successfully.');
        } catch (\Exception $e) {
            return $e->getMessage();
            
            return redirect()->back()->with('error', 'An error occurred while importing the data.');
        }
    }

    
}
