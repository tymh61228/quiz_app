<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Option;
use App\Models\Quiz;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AnswerTest extends TestCase
{
    use RefreshDatabase;

    private $category;
    private $quiz;
    private $quiz2;
    private $option1;
    private $option2;
    private $option3;
    private $option4;
    private $option5;
    private $option6;
    private $option7;
    private $option8;

    public function setUp(): void
    {
        parent::setUp();

        $this->category = Category::create([
            'name' => 'テストカテゴリー名1',
            'description' => 'テストカテゴリー説明文1',
        ]);
        $this->quiz = Quiz::create([
            'category_id' => $this->category->id,
            'question' => '問題',
            'explanation' => '説明',
        ]);
        $this->option1 = Option::create([
            'quiz_id' => $this->quiz->id,
            'content' => '選択肢1',
            'is_correct' => 1,
        ]);
        $this->option2 = Option::create([
            'quiz_id' => $this->quiz->id,
            'content' => '選択肢2',
            'is_correct' => 1,
        ]);
        $this->option3 = Option::create([
            'quiz_id' => $this->quiz->id,
            'content' => '選択肢3',
            'is_correct' => 1,
        ]);
        $this->option4 = Option::create([
            'quiz_id' => $this->quiz->id,
            'content' => '選択肢4',
            'is_correct' => 0,
        ]);

        $this->quiz2 = Quiz::create([
            'category_id' => $this->category->id,
            'question' => '問題',
            'explanation' => '説明',
        ]);
        $this->option5 = Option::create([
            'quiz_id' => $this->quiz2->id,
            'content' => '選択肢5',
            'is_correct' => 1,
        ]);
        $this->option6 = Option::create([
            'quiz_id' => $this->quiz2->id,
            'content' => '選択肢6',
            'is_correct' => 1,
        ]);
        $this->option7 = Option::create([
            'quiz_id' => $this->quiz2->id,
            'content' => '選択肢7',
            'is_correct' => 1,
        ]);
        $this->option8 = Option::create([
            'quiz_id' => $this->quiz2->id,
            'content' => '選択肢8',
            'is_correct' => 1,
        ]);
    }

    /**
     * @covers
     */
    #[Test]
    public function ステータス200が返ること(): void
    {
        $resultArray[] = [
            'quizId' => $this->quiz->id,
            'result' => true,
        ];

        $this->withSession(['resultArray' => $resultArray]);

        $response = $this->post(route(
            'categories.quizzes.answer',
            [
                'quizId' => $this->quiz->id,
                'optionId' =>
                [
                    $this->option1->id,
                    $this->option2->id,
                    $this->option3->id,
                    $this->option4->id,
                ],
                'categoryId' => $this->category->id
            ]
        ));

        $response->assertStatus(200);
    }

    /**
     * @covers
     */
    #[Test]
    public function クイズ解答画面が表示されること_不正解の場合(): void
    {
        $resultArray[] = [
            'quizId' => $this->quiz->id,
            'result' => true,
        ];

        $this->withSession(['resultArray' => $resultArray]);

        $response = $this->post(route(
            'categories.quizzes.answer',
            [
                'quizId' => $this->quiz->id,
                'optionId' =>
                [
                    $this->option1->id,
                    $this->option3->id,
                    $this->option4->id,
                ],
                'categoryId' => $this->category->id
            ]
        ))->assertSeeTextInOrder([
            'Incorrect...',
            'Qustion：問題',
            'Explanation：説明',
            'ID',
            'Option',
            'Correct or InCorrect',
            'Your Answer',
            '1',
            '選択肢1',
            '⚪︎',
            '⚪︎',
            '2',
            '選択肢2',
            '⚪︎',
            '×',
            '3',
            '選択肢3',
            '⚪︎',
            '⚪︎',
            '4',
            '選択肢4',
            '×',
            '⚪︎',
            'Next Question',
        ]);
    }

    /**
     * @covers
     */
    #[Test]
    public function クイズ解答画面が表示されること_正解の場合(): void
    {
        $resultArray[] = [
            'quizId' => $this->quiz2->id,
            'result' => true,
        ];

        $this->withSession(['resultArray' => $resultArray]);

        $response = $this->post(route(
            'categories.quizzes.answer',
            [
                'quizId' => $this->quiz2->id,
                'optionId' =>
                [
                    $this->option5->id,
                    $this->option6->id,
                    $this->option7->id,
                    $this->option8->id,
                ],
                'categoryId' => $this->category->id
            ]
        ))->assertSeeTextInOrder([
            'Correct!!!',
            'Qustion：問題',
            'Explanation：説明',
            'ID',
            'Option',
            'Correct or InCorrect',
            'Your Answer',
            '1',
            '選択肢5',
            '⚪︎',
            '⚪︎',
            '2',
            '選択肢6',
            '⚪︎',
            '⚪︎',
            '3',
            '選択肢7',
            '⚪︎',
            '⚪︎',
            '4',
            '選択肢8',
            '⚪︎',
            '⚪︎',
            'Next Question',
        ]);
    }
}
