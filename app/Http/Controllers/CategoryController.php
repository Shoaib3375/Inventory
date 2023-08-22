<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller {
    function categoryPage() {
        return view('pages.dashboard.category-page');
    }
    function categoryList(Request $request) {
        $user_id = $request->header('id');
        return Category::where('user_id', $user_id)->get();
    }

    function categoryCreate(Request $request) {
        $user_id = $request->header('id');
        return Category::create([
            'name'    => $request->input('name'),
            'user_id' => $user_id,
        ]);
    }
    function categoryDelete(Request $request) {
        $category_id = $request->input('id');
        $user_id = $request->header('id');
        return Category::where('id', $category_id)->where('user_id', $user_id)->delete();
    }
    function CategoryByID(Request $request) {
        $category_id = $request->input('id');
        $user_id = $request->header('id');
        return Category::where('id', $category_id)->where('user_id', $user_id)->first();
    }
    function categoryUpdate(Request $request) {
        $category_id = $request->input('id');
        $user_id = $request->header('id');
        return Category::where('id', $category_id)->where('user_id', $user_id)->update([
            'name' => $request->input('name'),
        ]);
    }
}