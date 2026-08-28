<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostPolicyTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_cannot_update_other_users_post()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        
        $post = Post::create([
            'user_id' => $user1->id,
            'title' => 'Original Title',
            'content' => 'Original Content',
        ]);

        $response = $this->actingAs($user2, 'api')
            ->putJson("/api/posts/{$post->id}", [
                'title' => 'Updated Title',
                'content' => 'Updated Content',
            ]);

        $response->assertStatus(403);
        $response->assertJson([
            'success' => false,
            'message' => 'You are not authorized to perform this action.',
        ]);
    }
}
