<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        return Category::all();
    }

    public function tree()
    {
        // $categories = Category::whereNull('parent_id')->get();

        // $nestedTrees = [];
        // foreach ($categories as $category) {
        //     $nestedTrees[] = $category->nestedTree();
        // }

        // return CategoryResour::collection(
        //     $categories = Category::whereNull('parent_id')->get();

        //     $nestedTrees = [];
        //     foreach ($categories as $category) {
        //         $nestedTrees[] = $category->nestedTree();
        // }
        // );
    }

    public function store(Request $request)
    {
        return Category::create($request->all());
    }

    public function show(Category $category)
    {
        return $category;
    }

    public function update(Request $request, Category $category)
    {
        $category->update($request->all());
        return $category;
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json(['message' => 'Category deleted successfully']);
    }
}