<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Option;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ShowTest extends TestCase
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
        $this->quiz = Quiz::create([
            'category_id' => $this->category->id,
            'question' => '問題',
            'explanation' => '説明',
        ]);
    }

    /**
     * @covers
     */
    #[Test]
    public function ステータス200が返ること(): void
    {
        $response = $this->get(route('admin.categories.show', ['categoryId' => $this->category->id]));

        $response->assertStatus(200);
    }

    /**
     * @covers
     */
    #[Test]
    public function カテゴリー詳細画面が表示されること(): void
    {
        $this->get(route('admin.categories.show', ['categoryId' => $this->category->id]))
            ->assertSeeTextInOrder([
                'テストカテゴリー名1',
                'テストカテゴリー説明文1',
                'Edit',
                'Create',
                'ID',
                'Quiz',
                'Update Date',
                'Edit',
                // '4',
                '問題',
                'Edit',
                'Delete',
            ]);
    }
}
