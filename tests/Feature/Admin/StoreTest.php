<?php

namespace Tests\Feature;

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
    }

    /**
     * @covers
     */
    #[Test]
    public function ステータス302が返ること(): void
    {
        $response = $this->post(route(
            'admin.categories.store',
            [
                'name' => 'カテゴリー',
                'description' => '説明',
            ]
        ));

        $response->assertStatus(302)->assertRedirect(route('admin.top'));;
    }
}
