<?php

namespace App\Imports;

use App\Models\Mag1;
use Maatwebsite\Excel\Concerns\ToModel;

class Mag1Import implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Mag1([
            "predicted_y_distance" => $row[0],
            "predicted_x_distance" => $row[1],
            "actual_y_distance" => $row[2],
            "actual_x_distance" => $row[3],
        ]);
    }
}
