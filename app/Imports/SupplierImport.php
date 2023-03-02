<?php

namespace App\Imports;

use App\Models\Supplier;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;

class SupplierImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    private $duplicates = [];

    public function model(array $row)
    {

        $suppliersdata = DB::table('Suppliers')->select('ice', 'email')->get();
        if (!empty($row) && isset($row)) {
            $duplicate_found = false;
            foreach ($suppliersdata as $data) {
                if ($data->ice === $row['ice'] || $data->email === $row['email']) {
                    $this->duplicates[] = $row;
                    $duplicate_found = true;
                    break;
                }
            }
            if (!$duplicate_found) {
                // no duplicate found, create new supplier
                return new Supplier([
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
