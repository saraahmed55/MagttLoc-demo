<?php

namespace App\Http\Controllers;

use App\Imports\DataImport;
use App\Imports\Mag1Import;
use App\Imports\Mag2Import;
use App\Imports\RTT1Import;
use App\Imports\RTT2Import;
use App\Imports\Trace2Import;
use App\Models\Data;
use App\Models\Mag1;
use App\Models\Mag2;
use App\Models\RTT1;
use App\Models\RTT2;
use App\Models\Trace2;
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

    // public function uploadData(Request $request)
    // {
    //     Excel::import(new DataImport,$request->file);
    //     return redirect()->back()->with('message', 'Data Saved Sucessfully!!');
    // }

    // public function uploadData(Request $request)
    // {
    //     Excel::import(new Trace2Import,$request->file);
    //     return redirect()->back()->with('message', 'Data Saved Sucessfully!!');
    // }

    // public function uploadData(Request $request)
    // {
    //     Excel::import(new RTT1Import,$request->file);
    //     return redirect()->back()->with('message', 'Data Saved Sucessfully!!');
    // }

    // public function uploadData(Request $request)
    // {
    //     Excel::import(new RTT2Import,$request->file);
    //     return redirect()->back()->with('message', 'Data Saved Sucessfully!!');
    // }

    // public function uploadData(Request $request)
    // {
    //     Excel::import(new Mag1Import,$request->file);
    //     return redirect()->back()->with('message', 'Data Saved Sucessfully!!');
    // }

    // public function uploadData(Request $request)
    // {
    //     Excel::import(new Mag2Import,$request->file);
    //     return redirect()->back()->with('message', 'Data Saved Sucessfully!!');
    // }

    public function showPointsforJS()
    {
        $data=Data::all();
        return response()->json(['data'=>$data]);
    }
    public function showTrace2PointsforJS()
    {
        $data=Trace2::all();
        return response()->json(['data'=>$data]);
    }
    public function showRTT1Points()
    {
        $data=RTT1::all();
        return response()->json(['data'=>$data]);
    }
    public function showRTT2Points()
    {
        $data=RTT2::all();
        return response()->json(['data'=>$data]);
    }
    public function showMag1Points()
    {
        $data=Mag1::all();
        return response()->json(['data'=>$data]);
    }
    public function showMag2Points()
    {
        $data=Mag2::all();
        return response()->json(['data'=>$data]);
    }
    public function showRealPoint()
    {
        $data = DB::table('magtt_loc')->select('actual_x_distance','actual_y_distance');
        return response()->json(['data'=>$data]);
    }

}
