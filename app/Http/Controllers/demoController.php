<?php

namespace App\Http\Controllers;

use App\Imports\DataImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class demoController extends Controller
{
    function data(Request $req)
    {
        return $req->input();
    }

    // function csvToArray($filename = '', $delimiter = ',')
    // {
    //     if (!file_exists($filename) || !is_readable($filename))
    //         return false;

    //     $header = null;
    //     $data = array();
    //     if (($handle = fopen($filename, 'r')) !== false)
    //     {
    //         while (($row = fgetcsv($handle, 1000, $delimiter)) !== false)
    //         {
    //             if (!$header)
    //                 $header = $row;
    //             else
    //                 $data[] = array_combine($header, $row);
    //         }
    //         fclose($handle);
    //     }

    //     return $data;
    // }

    public function uploadData(Request $request)
    {
        Excel::import(new DataImport,$request->file);
        return redirect()->route('demo')->with('success', 'Data Imported Successfully');
    }
}
