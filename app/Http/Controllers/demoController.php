<?php

namespace App\Http\Controllers;

use App\Imports\DataImport;
use App\Models\Data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class demoController extends Controller
{
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

    public function showPointsforJS()
    {
        $data=Data::all();
        return response()->json(['data'=>$data]);
        // return view('test')->with('data', $data);
    }
    public function showRealPoint()
    {
        $data = DB::table('magtt_loc')->select('actual_x_distance','actual_y_distance');
        return response()->json(['data'=>$data]);
    }

}
