<?php

namespace App\Imports;

use App\Models\RTT2;
use Maatwebsite\Excel\Concerns\ToModel;

class RTT2Import implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new RTT2([
            "predicted_y_distance" => $row[0],
            "predicted_x_distance" => $row[1],
            "actual_y_distance" => $row[2],
            "actual_x_distance" => $row[3],
        ]);
    }
}
