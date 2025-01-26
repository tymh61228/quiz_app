<?php

namespace Tests\Feature\Category;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DestroyTest extends TestCase
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
        $response = $this->post(route('admin.categories.destroy', ['categoryId' => $this->category->id]));

        $response->assertStatus(302)->assertRedirect(route('admin.top'));;
    }
}
