<?php

namespace App\Http\Controllers;

use App\Imports\DataImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class demoController extends Controller
{
    function data(Request $req)
    {
        return $req->input();
    }
    public function getPoints()
    {
        $data = DB::table('magtt_loc')->select('id','predicted_x_distance','predicted_y_distance','actual_x_distance','actual_y_distance')->paginate(10);

        return view('points')->with('data', $data);
    }

    public function uploadData(Request $request)
    {
        Excel::import(new DataImport,$request->file);
        // return redirect()->route('demo')->with('success', 'Data Imported Successfully');
        return redirect()->back()->with('message', 'Data Saved Sucessfully!!');
    }
}
