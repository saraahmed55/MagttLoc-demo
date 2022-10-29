<?php

namespace App\Imports;

use App\Models\Trace2;
use Maatwebsite\Excel\Concerns\ToModel;

class Trace2Import implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new trace2([
            "predicted_x_distance" => $row[0],
            "predicted_y_distance" => $row[1],
            "actual_x_distance" => $row[2],
            "actual_y_distance" => $row[3],
        ]);
    }
}
