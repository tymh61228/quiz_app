<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class TopTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @covers
     */
    #[Test]
    public function ステータス200が返ること(): void
    {
        $response = $this->get(route('top'));

        $response->assertStatus(200);
    }

    /**
     * @covers
     */
    #[Test]
    public function カテゴリー一覧が表示されること(): void
    {
        Category::create(['name' => 'テストカテゴリー1', 'description' => 'テスト説明文1',]);
        Category::create(['name' => 'テストカテゴリー2', 'description' => 'テスト説明文2',]);
        Category::create(['name' => 'テストカテゴリー3', 'description' => 'テスト説明文3',]);

        $this->get(route('top'))
            ->assertSeeText('Category')
            ->assertSeeInOrder([
                'テストカテゴリー1',
                'テストカテゴリー2',
                'テストカテゴリー3',
            ])
            ->assertSeeInOrder([
                'テスト説明文1',
                'テスト説明文2',
                'テスト説明文3',
            ]);
    }
}
