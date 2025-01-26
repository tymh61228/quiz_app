<?php

namespace Tests\Feature\Category;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdateTest extends TestCase
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
            'admin.categories.update',
            [
                'categoryId' => $this->category->id,
                'name' => 'カテゴリー',
                'description' => '説明',
            ]
        ));

        $response->assertStatus(302)->assertRedirect(route('admin.categories.show', ['categoryId' => $this->category->id]));;
    }
}
