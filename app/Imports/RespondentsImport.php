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
    public function  __construct($project)
    {
        $this->project = $project;
        echo $this->project;
    }
    public function model(array $row)

    {

        if ($row[0] == "View interviews") {
            return null;
        }

        return new Respondent([
            'res_d' => $row[1],
            'name' => $row[2],
            'project' => $this->project,
            'phone' => $row[4],
            'phone1' => $row[5],
            'phone2' => $row[6],
            'phhone3' => $row[7],
            'email' => $row[3],
            'occupation' => $row[8],
            'county' => $row[9],
            'town' => $row[10],
            'education' => $row[11],
            'sex' => $row[12],
            'lsm' => $row[13],
            'age' => $row[14],
            'status' => 'Active',
            'district' => $row[16],
            'division' => $row[17],
            'location' => $row[18],
            'sublocation' => $row[19],
            'ward' => $row[20],


        ]);
    }
}
