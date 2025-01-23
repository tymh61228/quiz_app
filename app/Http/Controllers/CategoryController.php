<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * 管理画面トップページ・カテゴリー一覧表示
     */
    public function top()
    {
        //カテゴリー一覧を取得
        $categories = Category::get();

        return view('admin.top', [
            'categories' => $categories,
        ]);
    }

    /**
     * カテゴリー新規登録画面表示
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * カテゴリ新規登録処理
     */
    public function store(StoreCategoryRequest $request)
    {
        $category = new Category();
        $category->name         = $request->name;
        $category->description  = $request->description;
        $category->save();

        return redirect()->route('admin.top');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
    }
}
