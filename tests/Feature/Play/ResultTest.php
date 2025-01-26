<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Option;
use App\Models\Quiz;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ResultTest extends TestCase
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
        $resultArray[] = [
            'quizId' => $this->quiz->id,
            'result' => true,
        ];
        $this->withSession(['resultArray' => $resultArray]);
        $response = $this->get(route('categories.quizzes.result', ['categoryId' => $this->category->id]));

        $response->assertStatus(200);
    }

    /**
     * @covers
     */
    #[Test]
    public function リザルト画面が表示できること(): void
    {
        $resultArray[] = [
            'quizId' => $this->quiz->id,
            'result' => true,
        ];
        $this->withSession(['resultArray' => $resultArray]);
        $response = $this->get(route('categories.quizzes.result', ['categoryId' => $this->category->id]))
            ->assertSeeTextInOrder([
                'Total',
                'Correct：1/1',
                'Retry',
                'Back to Category',
            ]);
    }
}
