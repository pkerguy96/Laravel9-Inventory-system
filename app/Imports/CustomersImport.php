<?php

namespace App\Imports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;

class CustomersImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    private $duplicates = [];
    public function model(array $row)
    {

        $customersdata = DB::table('customers')->select('ice', 'email')->get();
        if (!empty($row) && isset($row)) {
            $duplicate_found = false;
            foreach ($customersdata as $data) {
                if ($data->ice === $row['ice'] || $data->email === $row['email']) {
                    $this->duplicates = $row;
                    $duplicate_found = true;
                    break;
                }
            }
            if (!$duplicate_found) {
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
    }
    public function duplicatesrow()
    {

        return count($this->duplicates);
    }
}
