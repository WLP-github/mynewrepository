<?php

namespace FDA\Imports;

use FDA\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportUser implements ToModel
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        //
    }

    public function model(array $row){
        return new User([
            'name' => $row[0],
            'full_name' =>$row[1],
            'email' => $row[2],
            'department_id' => $row[3],
            'company_name' => $row[4],
            'company_registration_no' => $row[5],
            'company_phone_no' => $row[6],
            'registration_date' => $row[7],
            'applicant_name' => $row[8], 
            'applicant_phone_no' => $row[9],
            'applicant_nrc' => $row[10],
            'is_active' => $row[11],
            'password' => trim($row[12]),
            'email_verified_at' => $row[13],
            'role' => $row[14],
            'role_id' => $row[15],
            'remember_token' => $row[16],
            'cancel_time' => $row[17],
            'created_at' => date("Y-m-d", strtotime("today")),
            'updated_at' => date("Y-m-d", strtotime("today")),
        ]);
    }
}
