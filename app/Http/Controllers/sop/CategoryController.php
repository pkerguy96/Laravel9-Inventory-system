<?php

namespace App\Http\Controllers\sop;

use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Imports\CategoryImport;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class CategoryController extends Controller
{
    /* function that grabs all the Units */
    public function AllCategories()
    {
        $categories = Category::latest()->get();

        return view('backend.Category.all_category', compact('categories'));
    }
    public function Addcategory()
    {

        return view('backend.Category.add_category');
    }
    /* adds Category in DB */
    public function Storecategory(Request $request)
    {
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
    }
    /* redirects to Category page to modify it  */
    public function Editcategory($id)
    {
        $categoryinfo = Category::findorfail($id);
        return view('backend.Category.Edit_category', compact("categoryinfo"));
    }
    public function Modifycategory(request $request)
    {
        $id = $request->categoryid;
        Category::findorfail($id)->update([
            'category_name' =>  $request->name,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(),
        ]);
        $notification = array(
            'message' => 'Category Modified Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.Categories')->with($notification);
    }
    public function Deletecategory($id)
    {
        Category::findorfail($id)->delete();
        $notification = array(
            'message' => 'Category Deleted Successfully',
            'alert-type' => 'info'
        );

        return redirect()->route('all.Categories')->with($notification);
    }
}
