<?php

namespace App\Imports;

use App\Models\Data;
use Maatwebsite\Excel\Concerns\ToModel;


class DataImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Data([
            "predicted_x_distance" => $row[0],
            "predicted_y_distance" => $row[1],
            "actual_x_distance" => $row[2],
            "actual_y_distance" => $row[3],
        ]);
    }
}
