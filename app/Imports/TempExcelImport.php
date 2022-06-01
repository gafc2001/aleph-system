<?php

namespace App\Imports;

use App\Models\TempExcel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TempExcelImport implements WithHeadingRow,OnEachRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new TempExcel([
            'full_name' => $row['id_de_usuario'],
            'time' => $row['nombre'],
            'state' => $row['tiempo'],
            'location' => $row['nombre_de_la_terminal'],
        ]);

    }
}
