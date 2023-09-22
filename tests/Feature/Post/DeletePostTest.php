<?php

namespace Tests\Feature\Post;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeletePostTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that a post can be deleted by super admin.
     */
    public function test_post_can_be_deleted_by_super_admin(): void
    {
        $this->withoutExceptionHandling();

        // Run PermissionSeeder
        $this->artisan('db:seed', ['--class' => 'PermissionSeeder']);
        $this->artisan('db:seed', ['--class' => 'PostSeeder']);

        // Act as a user with "super-admin" role
        $this->actingAs(\App\Models\User::factory()->create()->assignRole('super-admin'));

        $response = $this->delete('/posts/10');

        $response->assertRedirect('/posts');
        $this->assertDatabaseMissing('posts', [
            'id' => 10,
        ]);
    }

    /**
     * Test that a post can not be deleted by a guest.
     */
    public function test_post_can_not_be_deleted_by_guest(): void
    {
        $response = $this->delete('/posts/1');

        $response->assertRedirect('/login');
    }

    /**
     * Test that a post can not be deleted by a support user.
     */
    public function test_post_can_not_be_deleted_by_support_user(): void
    {
        // Run PermissionSeeder
        $this->artisan('db:seed', ['--class' => 'PermissionSeeder']);
        $this->artisan('db:seed', ['--class' => 'PostSeeder']);

        // Act as a user with "support" role
        $this->actingAs(\App\Models\User::factory()->create()->assignRole('support'));

        $response = $this->delete('/posts/1');

        $response->assertNotFound();
    }

    /**
     * Test that a post can not be deleted by a developer user.
     */
    public function test_post_can_not_be_deleted_by_developer_user(): void
    {
        // Run PermissionSeeder
        $this->artisan('db:seed', ['--class' => 'PermissionSeeder']);
        $this->artisan('db:seed', ['--class' => 'PostSeeder']);

        // Act as a user with "developer" role
        $this->actingAs(\App\Models\User::factory()->create()->assignRole('developer'));

        $response = $this->delete('/posts/1');

        $response->assertNotFound();
    }
}
