<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use App\Services\TopUserDataService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TopUserDataTest extends TestCase
{
    use RefreshDatabase;
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        User::factory()->create(['username' => 'watchCrunch']);
        Post::factory()->createMany([
            ['created_at' => Carbon::now()->subDays(5)],
            ['created_at' => Carbon::now()->subDays(8)],
            ['created_at' => Carbon::now()->subDays(2)],
            ['created_at' => Carbon::now()->subDays(8)],
            ['created_at' => Carbon::now()->subDay(), 'title' => 'watchCrunch'],
        ]);
    }


    public function test_top_user_data(): void
    {
        $topUserData = new TopUserDataService();

        $result = $topUserData->topUserData(7, 2);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('username', $result[0]);
        $this->assertArrayHasKey('total_posts_count', $result[0]);
        $this->assertArrayHasKey('last_post_title', $result[0]);
        $this->assertEquals('watchCrunch', $result[0]['username']);
        $this->assertEquals(3, $result[0]['total_posts_count']);
        $this->assertEquals("watchCrunch", $result[0]['last_post_title']);

    }
}
