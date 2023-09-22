<?php

namespace Tests\Feature\Post;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdatePostTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that the update post screen cannot be rendered by a guest.
     */
    public function test_update_post_screen_cannot_be_rendered_by_guest(): void
    {
        $response = $this->get('/posts/1/edit');

        $response->assertRedirect('/login');
    }

    /**
     * Test that the update post screen can not be rendered by an authenticated support user.
     */
    public function test_update_post_screen_can_not_be_rendered_by_authenticated_support_user(): void
    {
        // Run PermissionSeeder
        $this->artisan('db:seed', ['--class' => 'PermissionSeeder']);
        $this->artisan('db:seed', ['--class' => 'PostSeeder']);

        // Act as a user with "support" role
        $this->actingAs(\App\Models\User::factory()->create()->assignRole('support'));

        $response = $this->get('/posts/5/edit');

        $response->assertNotFound();
    }

    /**
     * Test that the update post screen can be rendered by an authenticated super admin.
     */
    public function test_update_post_screen_can_be_rendered_by_authenticated_super_admin(): void
    {
        $this->withoutExceptionHandling();

        // Run PermissionSeeder
        $this->artisan('db:seed', ['--class' => 'PermissionSeeder']);

        // Act as a user with "super-admin" role
        $user = \App\Models\User::factory()->create()->assignRole('super-admin');
        $this->actingAs($user);

        $post = Post::factory()->create(['user_id' => $user->id]);

        $response = $this->get(route('posts.edit', $post));

        $response->assertStatus(200);
    }

    /**
     * Test that a post can be updated by super admin.
     */
    public function test_post_can_be_updated_by_super_admin(): void
    {
        $this->withoutExceptionHandling();

        // Run PermissionSeeder
        $this->artisan('db:seed', ['--class' => 'PermissionSeeder']);

        // Act as a user with "super-admin" role
        $user = \App\Models\User::factory()->create()->assignRole('super-admin');
        $this->actingAs($user);

        $post = Post::factory()->create(['user_id' => $user->id]);

        $response = $this->put(route('posts.update', $post), [
            'title' => 'Test Title',
            'content' => 'Test Body',
        ]);

        $response->assertRedirect(route('posts.show', $post));
        $this->assertDatabaseHas('posts', [
            'title' => 'Test Title',
            'content' => 'Test Body',
        ]);
    }
}
