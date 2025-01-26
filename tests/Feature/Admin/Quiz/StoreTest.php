<?php

namespace Tests\Feature\Quiz;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    private $category;
    private $quiz;
    private $options;

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
    }

    /**
     * @covers
     */
    #[Test]
    public function ステータス302が返ること(): void
    {
        $response = $this->post(route(
            'admin.categories.quizzes.store',
            [
                'categoryId' => $this->category->id,
                'question' => 'カテゴリー',
                'explanation' => '説明',
                'content1' => '選択肢',
                'isCorrect1' => 1,
                'content2' => '選択肢',
                'isCorrect2' => 1,
                'content3' => '選択肢',
                'isCorrect3' => 1,
                'content4' => '選択肢',
                'isCorrect4' => 1,
            ]
        ));

        $response->assertStatus(302)->assertRedirect(route('admin.categories.show', ['categoryId' => $this->category->id]));;
    }
}
