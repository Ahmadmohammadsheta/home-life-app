<?php

namespace Tests\Feature\Category;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategotyTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_index(): void
    {
        $response = $this->get('/categories');

        $response->assertStatus(302);
    }

    public function test_show(): void
    {
        $response = $this->get('/categories/1');

        // $response->assertViewIs('crud.show');
        $response->assertStatus(302);
    }

    public function test_create(): void
    {
        // Create a new user
        $user = User::factory()->create();

        // Login the user
        // $this->actingAs($user);


        $response = $this->get('/categories/create');

        $response->assertStatus(302);

        // $response->assertSee('Done');
        // $response->assertViewIs('crud.create');
    }

    public function test_store(): void
    {
        // Create a new user
        $user = User::factory()->create();

        // Login the user
        $this->actingAs($user);

        // Send a POST request to the create category route
        $response = $this->post(route('categories.store'), [
            'name' => 'New Category',
            'is_parent' => '1',
            'type_id' => '1'
        ]);

        // Assert that the response is a redirect
        $response->assertStatus(200);
        $response->assertRedirect();

        // Assert that the category was created
        $this->assertDatabaseHas('categories', [
            'name' => 'New Category',
            'is_parent' => '1',
            'type_id' => '1'
        ]);
    }
}
