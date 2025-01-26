<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Option;
use App\Models\Quiz;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class StartTest extends TestCase
{
    use RefreshDatabase;

    private $category1;
    private $category2;
    private $quiz;
    private $options;

    public function setUp(): void
    {
        parent::setUp();

        $this->category1 = Category::create([
            'name' => 'テストカテゴリー名1',
            'description' => 'テストカテゴリー説明文1',
        ]);
        $this->category2 = Category::create([
            'name' => 'テストカテゴリー名2',
            'description' => 'テストカテゴリー説明文2',
        ]);
        $this->quiz = Quiz::create([
            'category_id' => $this->category2->id,
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
        $response = $this->get(route('categories.start', ['categoryId' => $this->category1->id]));

        $response->assertStatus(200);
    }

    /**
     * @covers
     */
    #[Test]
    public function カテゴリー一覧が表示されること_クイズがない場合(): void
    {
        $this->get(route('categories.start', ['categoryId' => $this->category1->id]))
            ->assertSeeTextInOrder([
                'テストカテゴリー名',
                'テストカテゴリー説明文1',
                'Coming Soon...'
            ]);
    }

    /**
     * @covers
     */
    #[Test]
    public function カテゴリー一覧が表示されること_クイズがある場合(): void
    {
        $this->get(route('categories.start', ['categoryId' => $this->category2->id]))
            ->assertSeeTextInOrder([
                'テストカテゴリー名2',
                'テストカテゴリー説明文2',
                'Start'
            ]);
    }
}
