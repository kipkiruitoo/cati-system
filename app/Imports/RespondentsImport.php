<?php

namespace App\Imports;

use App\Respondent;
use Maatwebsite\Excel\Concerns\ToModel;

class RespondentsImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)

    {

        if ($row[0] == "View interviews") {
            return null;
        }
        return new Respondent([
            'res_d' => $row[1],
            'name' => $row[2],
            'phone' => $row[4],
            'email' => $row[3],
            'occupation' => $row[5],
            'county' => $row[6],
            'town' => $row[7],
            'education' => $row[8],
            'sex' => $row[9],
            'lsm' => $row[10],
            'age' => $row[11],
            'status' => $row[12]


        ]);
    }
}
