<?php

namespace App\Imports;

use App\Models\Brand;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class BrandsImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    private $duplicates = [];
    public function model(array $row)
    {
        $brandsname = DB::table('brands')->get();
        $brandsnumber = $brandsname->pluck('Brand_name');

        if (!empty($row) && isset($row['brand_name'])) {
            if (!$brandsnumber->contains($row['brand_name'])) {
                return new Brand([
                    "Brand_name" => $row['brand_name'],
                    "status" => 1,
                    'created_by' => Auth::user()->id,
                    'created_at' => Carbon::now(),
                ]);
            } else {
                $this->duplicates[] = $row['brand_name'];
            }
        }
    }
    public function getDuplicates()
    {
        return $this->duplicates;
    }
}
