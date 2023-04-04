<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteCategoryRequest;
use App\Http\Requests\EditCategoryRequest;
use App\Models\Category;
use App\Http\Requests\IndexCategoryRequest;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    public function index(IndexCategoryRequest $request)
    {
        return response()->json(CategoryResource::collection(Category::all()));
    }

    public function edit(EditCategoryRequest $request)
    {
        return response()->json([
            'categories' => Category::where('parent_category_id', null)->get(),
            'subcategories' => Category::whereNotNull('parent_category_id')->get(),
        ]);
    }

    public function store(StoreCategoryRequest $request)
    {
        $category = Category::create([
            'name' => $request->name,
            'parent_category_id' => $request->parent_category_id,
        ]);
        return new CategoryResource($category);
    }

    public function delete(Category $category, DeleteCategoryRequest $request)
    {
        Category::where('parent_category_id', $category->id)->delete();
        return response()->json($category->delete());
    }
}
