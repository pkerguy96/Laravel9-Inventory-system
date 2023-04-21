<?php

namespace App\Http\Controllers\sop;

use Illuminate\Support\Facades\Log;
use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Imports\CategoryImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class CategoryController extends Controller
{
    /* function that grabs all the Units */
    public function AllCategories()
    {
        try {
            $categories = Category::latest()->get();
            return view('backend.Category.all_category', compact('categories'));
        } catch (\Exception $e) {
            Log::error('AllCategories function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }
    public function Addcategory()
    {
        return view('backend.Category.add_category');
    }
    /* adds Category in DB */
    public function Storecategory(Request $request)
    {
        try {
            if ($request->hasFile('brands_cvs')) {
                $import = new CategoryImport();
                Excel::import($import, $request->file('brands_cvs'));
                $duplicates = $import->getDuplicates();
                if ($duplicates > 0) {
                    $notification = InsertNotification($duplicates . ' Categories Were Skipped The Rest Is  Imported Successfuly', 'info');
                } else {
                    $notification = InsertNotification('Categories Imported Successfuly', 'success');
                }
                return redirect()->route('all.Categories')->with($notification);
            } else {
                Category::insert([
                    'category_name' =>  $request->name,
                    'created_by' => Auth::user()->id,
                    'created_at' => Carbon::now(),
                ]);
                $notification = InsertNotification('Category Added Successfully', 'success');
                return redirect()->route('all.Categories')->with($notification);
            }
        } catch (\Exception $e) {
            Log::error('Storecategory function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }
    /* redirects to Category page to modify it  */
    public function Editcategory($id)
    {
        try {
            $categoryinfo = Category::findorfail($id);
            return view('backend.Category.Edit_category', compact("categoryinfo"));
        } catch (\Exception $e) {
            Log::error('Editcategory function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }
    public function Modifycategory(request $request)
    {
        try {
            $id = $request->categoryid;
            Category::findorfail($id)->update([
                'category_name' =>  $request->name,
                'updated_by' => Auth::user()->id,
                'updated_at' => Carbon::now(),
            ]);
            $notification = InsertNotification('Category Modified Successfully', 'success');
            return redirect()->route('all.Categories')->with($notification);
        } catch (\Exception $e) {
            Log::error('Modifycategory function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }
    public function Deletecategory($id)
    {
        try {
            Category::findorfail($id)->delete();
            $notification = InsertNotification('Category Deleted Successfully', 'info');
            return redirect()->route('all.Categories')->with($notification);
        } catch (\Exception $e) {
            Log::error('Deletecategory function: ' . $e->getMessage());
            report($e);
            abort(404);
        }
    }
}
