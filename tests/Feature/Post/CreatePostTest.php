<?php

namespace Tests\Feature\Post;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreatePostTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that the create post screen cannot be rendered by a guest.
     */
    public function test_create_post_screen_cannot_be_rendered_by_guest(): void
    {
        $response = $this->get('/posts/create');

        $response->assertRedirect('/login');
    }

    /**
     * Test that a post can be created by super admin.
     */
    public function test_post_can_be_created_by_super_admin(): void
    {
        $this->withoutExceptionHandling();

        // Run PermissionSeeder
        $this->artisan('db:seed', ['--class' => 'PermissionSeeder']);

        // Act as a user with "super-admin" role
        $this->actingAs(\App\Models\User::factory()->create()->assignRole('super-admin'));

        $response = $this->post('/posts', [
            'title' => 'Test Title',
            'content' => 'Test Body',
        ]);

        $response->assertRedirect('/posts/1');
        $this->assertDatabaseHas('posts', [
            'title' => 'Test Title',
            'content' => 'Test Body',
        ]);
    }

    /**
     * Test that a post can not be created with an empty title by super admin.
     */
    public function test_post_can_not_be_created_with_empty_title_by_super_admin(): void
    {
        // Run PermissionSeeder
        $this->artisan('db:seed', ['--class' => 'PermissionSeeder']);

        // Act as a user with "super-admin" role
        $this->actingAs(\App\Models\User::factory()->create()->assignRole('super-admin'));

        $response = $this->post('/posts', [
            'title' => '',
            'content' => 'Test Body',
        ]);

        $response->assertSessionHasErrors('title');
    }

    /**
     * Test that a post can not be created with an empty content by super admin.
     */
    public function test_post_can_not_be_created_with_empty_content_by_super_admin(): void
    {
        // Run PermissionSeeder
        $this->artisan('db:seed', ['--class' => 'PermissionSeeder']);

        // Act as a user with "super-admin" role
        $this->actingAs(\App\Models\User::factory()->create()->assignRole('super-admin'));

        $response = $this->post('/posts', [
            'title' => 'Test Title',
            'content' => '',
        ]);

        $response->assertSessionHasErrors('content');
    }

    /**
     * Test that a post can not be created by a support user.
     */
    public function test_post_can_not_be_created_by_support_user(): void
    {
        // Run PermissionSeeder
        $this->artisan('db:seed', ['--class' => 'PermissionSeeder']);

        // Act as a user with "support" role
        $this->actingAs(\App\Models\User::factory()->create()->assignRole('support'));

        $response = $this->post('/posts', [
            'title' => 'Test Title',
            'content' => 'Test Body',
        ]);

        $response->assertForbidden();
    }

    /**
     * Test that a post can be created by a developer user.
     */
    public function test_post_can_be_created_by_developer_user(): void
    {
        $this->withoutExceptionHandling();

        // Run PermissionSeeder
        $this->artisan('db:seed', ['--class' => 'PermissionSeeder']);

        // Act as a user with "developer" role
        $this->actingAs(\App\Models\User::factory()->create()->assignRole('developer'));

        $response = $this->post('/posts', [
            'title' => 'Test Title',
            'content' => 'Test Body',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('posts', [
            'title' => 'Test Title',
            'content' => 'Test Body',
        ]);
    }
}
