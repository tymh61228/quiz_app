<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Option;
use App\Models\Quiz;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class QuizzesTest extends TestCase
{
    use RefreshDatabase;

    private $category;
    private $quiz;
    private $options;

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
        $this->options = Option::create([
            'quiz_id' => $this->quiz->id,
            'content' => '選択肢1',
            'is_correct' => 1,
        ]);
        $this->options = Option::create([
            'quiz_id' => $this->quiz->id,
            'content' => '選択肢2',
            'is_correct' => 1,
        ]);
        $this->options = Option::create([
            'quiz_id' => $this->quiz->id,
            'content' => '選択肢3',
            'is_correct' => 1,
        ]);
        $this->options = Option::create([
            'quiz_id' => $this->quiz->id,
            'content' => '選択肢4',
            'is_correct' => 0,
        ]);
    }

    /**
     * @covers
     */
    #[Test]
    public function ステータス200が返ること(): void
    {
        $response = $this->get(route('categories.quizzes', ['categoryId' => $this->category->id]));

        $response->assertStatus(200);
    }

    /**
     * @covers
     */
    #[Test]
    public function クイズ出題画面が表示されること(): void
    {
        $this->get(route('categories.quizzes', ['categoryId' => $this->category->id]))
            ->assertSeeTextInOrder([
                'Question',
                '問題',
                'ID',
                'Option',
                '1',
                '選択肢1',
                '2',
                '選択肢2',
                '3',
                '選択肢3',
                '4',
                '選択肢4',
                'Answer',
            ]);
    }

    /**
     * @covers
     */
    #[Test]
    public function カテゴリーの内最終問題の場合(): void
    {
        $resultArray[] = [
            'quizId' => $this->quiz->id,
            'result' => true,
        ];
        $this->withSession(['resultArray' => $resultArray]);
        $this->get(route('categories.quizzes', ['categoryId' => $this->category->id]))
            ->assertStatus(302)->assertRedirect(route('categories.quizzes.result', ['categoryId' => $this->category->id]));
    }
}
