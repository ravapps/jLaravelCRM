<?php

namespace App\Imports;
use App\Models\Jbr;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class JbrImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Jbr([
            'designation_id'     => $row[0],  /// todo
            'res_name'    => $row[1],
            'created_by'    => $row[2]
        ]);
    }
}
