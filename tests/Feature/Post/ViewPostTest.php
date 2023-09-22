<?php

namespace Tests\Feature\Post;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewPostTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that the view post screen cannot be rendered by a guest.
     */
    public function test_view_post_screen_cannot_be_rendered_by_guest(): void
    {
        $response = $this->get('/posts');

        $response->assertRedirect('/login');
    }

    /**
     * Test that the view post screen can be rendered by an authenticated support user.
     */
    public function test_view_post_screen_can_be_rendered_by_authenticated_support_user(): void
    {
        $this->withoutExceptionHandling();

        // Run PermissionSeeder
        $this->artisan('db:seed', ['--class' => 'PermissionSeeder']);
        $this->artisan('db:seed', ['--class' => 'PostSeeder']);

        // Act as a user with "support" role
        $this->actingAs(\App\Models\User::factory()->create()->assignRole('support'));

        $response = $this->get('/posts');

        $response->assertStatus(200);
    }
}
