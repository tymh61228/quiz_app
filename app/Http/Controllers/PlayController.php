<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class PlayController extends Controller
{
    /**
     * プレイ画面トップページ
     */
    public function top()
    {
        $categories = Category::all();
        return view('play.top', [
            'categories' => $categories,
        ]);
    }

    /**
     * クイズスタート画面表示
     */
    public function categories(Request $request, int $categoryId)
    {
        session()->forget('resultArray');

        $category = Category::withCount('quizzes')->findOrFail($categoryId);
        return view('play.start', [
            'category' => $category,
            'quizzesCount' => $category->quizzes_count,
        ]);
    }

    /**
     * クイズ出題画面
     */
    public function quizzes(Request $request, int $categoryId)
    {
        $category = Category::with('quizzes.options')->findOrFail($categoryId);

        $resultArray = session('resultArray');

        if (is_null($resultArray)) {
            $quizIds = $category->quizzes->pluck('id')->toArray();
            shuffle($quizIds);
            $resultArray = [];

            foreach ($quizIds as $quizId) {
                $resultArray[] = [
                    'quizId' => $quizId,
                    'result' => null,
                ];
            }
            session(['resultArray' => $resultArray]);
        }

        $noAnswerResult = collect($resultArray)->filter(function ($item) {
            return $item['result'] === null;
        })->first();

        if (!$noAnswerResult) {
        }

        $quiz = $category->quizzes->firstWhere('id', $noAnswerResult['quizId'])->toArray();

        return view('play.quizzes', [
            'categoryId' => $categoryId,
            'quiz' => $quiz,
        ]);
    }

    /**
     * クイズ解答画面
     */
    public function answer(Request $request, int $categoryId)
    {
        $quizId = $request->quizId;
        $selectedOptions = $request->optionId === null ? [] : $request->optionId;

        $category = Category::with('quizzes.options')->findOrFail($categoryId);
        $quiz = $category->quizzes->firstWhere('id', $quizId);
        $quizOptions = $quiz->options->toArray();

        $isCorrectAnswer = $this->isCorrectAnswer($selectedOptions,  $quizOptions);

        $resultArray = session('resultArray');

        foreach ($resultArray as $index => $result) {
            if ($result['quizId'] === (int)$quizId) {
                $resultArray[$index]['result'] = $isCorrectAnswer;
                break;
            }
        }
        session(['resultArray' => $resultArray]);

        return view('play.answer', [
            'isCorrectAnswer'   => $isCorrectAnswer,
            'quiz'              => $quiz->toArray(),
            'quizOptions'       => $quizOptions,
            'selectedOptions'   => $selectedOptions,
            'categoryId'        => $categoryId,
        ]);
    }

    /**
     * プレイヤーの回答が正解か不正解かを判定
     */
    private function isCorrectAnswer(array $selectedOptions, array $quizOptions)
    {
        $correctOptions = array_filter($quizOptions, function ($option) {
            return $option['is_correct'] === 1;
        });

        $correctOptionIds = array_map(function ($option) {
            return $option['id'];
        }, $correctOptions);

        if (count($selectedOptions) !== count($correctOptionIds)) {
            return false;
        }

        foreach ($selectedOptions as $selectedOption) {
            if (!in_array((int)$selectedOption, $correctOptionIds)) {
                return false;
            }
        }

        return true;
    }
}
