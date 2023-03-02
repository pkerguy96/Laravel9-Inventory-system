<?php

namespace App\Imports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CustomersImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Customer([
            'name' => $row['name'],
            'phone' => $row['phone'],
            'email' => $row['email'],
            'address' => $row['address'],
            'ice' => $row['ice'],
            'status' => 1,
            'created_by' => Auth::user()->id,
        ]);
    }
}
