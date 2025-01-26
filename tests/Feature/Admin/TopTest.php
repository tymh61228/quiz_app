<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class TopTest extends TestCase
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
            'updated_at' => '2025-01-01 00:00:00'
        ]);
    }

    /**
     * @covers
     */
    #[Test]
    public function ステータス200が返ること(): void
    {
        $response = $this->get(route('admin.top'));

        $response->assertStatus(200);
    }

    /**
     * @covers
     */
    #[Test]
    public function 管理者トップ画面が表示されること(): void
    {
        $this->get(route('admin.top'))
            ->assertSeeTextInOrder([
                'Category',
                'Create Category',
                'ID',
                'Category Name',
                'Update Date',
                'Detail',
                'delete',
                // '7',
                'テストカテゴリー名1',
                'Detail',
                'Delete',
            ]);
    }
}
