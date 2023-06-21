<?php

namespace App\Imports;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel,  WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return User|null
     */
    public function model(array $row)
    {
        // return $row->get();
        return new User([
           'nama' => $row['nama'],
           'username' => $row['username'], 
           'email' => $row['email'], 
           'password' => Hash::make($row['password']),
        ]);
    }
}