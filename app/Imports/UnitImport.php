<?php

namespace App\Imports;

use App\Models\Unit;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Auth;

use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;

class UnitImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    private $duplicates = [];
    public function model(array $row)
    {
        $units = DB::table('units')->get();
        $units_name = $units->pluck('unit_name');
        if (!empty($row) && isset($row)) {
            if (!$units_name->contains($row['unit_name'])) {
                return new Unit([
                    'unit_name' => $row['unit_name'],
                    'status' => 1,
                    'created_by' => Auth::user()->id,
                ]);
            } else {
                $this->duplicates[] = $row['unit_name'];
            }
        }
    }
    public function getduplicates()
    {
        $dups_count = count($this->duplicates);
        return $dups_count;
    }
}
