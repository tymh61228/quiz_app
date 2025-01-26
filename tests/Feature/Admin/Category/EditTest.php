<?php

namespace Tests\Feature\Category;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class EditTest extends TestCase
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
    public function ステータス200が返ること(): void
    {
        $response = $this->get(route('admin.categories.edit', ['categoryId' => $this->category->id]));

        $response->assertStatus(200);
    }

    /**
     * @covers
     */
    #[Test]
    public function カテゴリー編集画面が表示されること(): void
    {
        $this->get(route('admin.categories.edit', ['categoryId' => $this->category->id]))
            ->assertSeeTextInOrder([
                'Edit Category',
                'Category Name',
                'Category Description',
                'テストカテゴリー説明文1',
                'Update',
            ]);
    }
}
