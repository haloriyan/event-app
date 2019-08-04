<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function store(Request $req) {
        $cat = new Category;
        $cat->category = $req->category;
        $cat->hit = 0;
        $cat->save();

        return redirect()->route('admin.category');
    }
    public function delete($id) {
        $cat = Category::find($id);
        $cat->delete();

        return redirect()->route('admin.category');
    }
    public function search(Request $req) {
        $get = Category::where([['category', 'LIKE', '%'.$req->q.'%']])->get();
        return $get;
    }
}
