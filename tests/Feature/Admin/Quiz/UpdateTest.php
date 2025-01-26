<?php

namespace Tests\Feature\Quiz;

use App\Models\Category;
use App\Models\Option;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    use RefreshDatabase;

    private $category;
    private $quiz;
    private $option1;
    private $option2;
    private $option3;
    private $option4;

    public function setUp(): void
    {
        parent::setUp();

        // テスト用ユーザーを作成
        $user = User::factory()->create([
            'password' => bcrypt($password = 'password'),
        ]);

        // ユーザーとしてログイン
        $this->actingAs($user);

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
    }

    /**
     * @covers
     */
    #[Test]
    public function ステータス302が返ること(): void
    {
        $response = $this->post(route(
            'admin.categories.quizzes.update',
            [
                'categoryId' => $this->category->id,
                'quizId' => $this->quiz->id,
                'question' => '問題',
                'explanation' => '説明',
                'optionId1' => $this->option1->id,
                'content1' => '選択肢',
                'isCorrect1' => 1,
                'optionId2' => $this->option1->id,
                'content2' => '選択肢',
                'isCorrect2' => 1,
                'optionId3' => $this->option1->id,
                'content3' => '選択肢',
                'isCorrect3' => 1,
                'optionId4' => $this->option1->id,
                'content4' => '選択肢',
                'isCorrect4' => 1,
            ]
        ));

        $response->assertStatus(302)->assertRedirect(route('admin.categories.show', ['categoryId' => $this->category->id]));;
    }
}
