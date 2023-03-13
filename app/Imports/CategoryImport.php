<?php

namespace App\Imports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CategoryImport implements ToModel, WithHeadingRow

{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    private $duplicates = [];
    public function model(array $row)
    {
        $categories = DB::table('categories')->get();
        $cat = $categories->pluck('category_name');

        if (!empty($row) && isset($row)) {
            if (!$cat->contains($row['category_name'])) {
                return new Category([
                    'category_name' => $row['category_name'],
                    'status' => 1,
                    'created_by' => Auth::user()->id,
                ]);
            } else {
                $this->duplicates[] = $row;
            }
        }
    }
    public function getDuplicates()
    {
        return count($this->duplicates);
    }
}
