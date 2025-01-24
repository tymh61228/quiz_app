<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

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
     * カテゴリー詳細・クイズ一覧画面表示
     */
    public function show(Request $request, int $categoryId)
    {
        $category = Category::with('quizzes')->findOrFail($categoryId);


        return view('admin.categories.show', [
            'category'  => $category,
            'quizzes'   => $category->quizzes,
        ]);
    }

    /**
     * カテゴリー編集画面表示
     */
    public function edit(Request $request, int $categoryId)
    {
        $category = Category::findOrFail($categoryId);

        return view('admin.categories.edit', [
            'category' => $category,
        ]);
    }

    /**
     * カテゴリー更新処理
     */
    public function update(UpdateCategoryRequest $request, int $categoryId)
    {
        $category = Category::findOrFail($categoryId);
        $category->name         = $request->name;
        $category->description  = $request->description;
        $category->save();

        return redirect()->route('admin.categories.show', ['categoryId' => $categoryId]);
    }

    /**
     * カテゴリー削除処理
     */
    public function destroy(Request $request, int $categoryId)
    {
        $category = Category::findOrFail($categoryId);
        $category->delete();

        return redirect()->route('admin.top');
    }
}
