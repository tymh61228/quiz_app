<?php

namespace Tests\Feature\Quiz;

use App\Models\Category;
use App\Models\Option;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class EditTest extends TestCase
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
    public function ステータス200が返ること(): void
    {
        $response = $this->get(route(
            'admin.categories.quizzes.edit',
            [
                'categoryId' => $this->category->id,
                'quizId' => $this->quiz->id,
            ]
        ));

        $response->assertStatus(200);
    }

    /**
     * @covers
     */
    #[Test]
    public function クイズ編集画面が表示されること(): void
    {
        $this->get(route(
            'admin.categories.quizzes.edit',
            [
                'categoryId' => $this->category->id,
                'quizId' => $this->quiz->id,
            ]
        ))->assertSeeTextInOrder([
            'Edit Quiz',
            'Question',
            '問題',
            'Explanation',
            '説明',
            'Option1',
            'Correct・Incorrect of Option1',
            '正解',
            '不正解',
            'Option2',
            'Correct・Incorrect of Option2',
            '正解',
            '不正解',
            'Option3',
            'Correct・Incorrect of Option3',
            '正解',
            '不正解',
            'Option4',
            'Correct・Incorrect of Option4',
            '正解',
            '不正解',
            'Update',
        ]);
    }
}
