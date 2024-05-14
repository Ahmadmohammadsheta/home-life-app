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
        $user = User::factory()->create();

        $this->withoutMiddleware('auth');
        $response = $this
            ->actingAs($user)
            ->get('/categories/create');

        $response->assertStatus(302);

        // $response->assertSee('Done');
        // $response->assertViewIs('crud.create');
    }

    public function test_store(): void
    {
        $user = User::factory()->create();

        $response = $this
            // ->actingAs($user)
            ->post('/categories', [
                'name' => 'test',
                'is_parent' => 1,
                'parent_id' => 0,
                'type_id' => 1
            ]);

        $response->assertStatus(201);
        // $response->assertRedirect('crud.show');
        // $response->assertViewIs('crud.create');
    }

    public function test_edit(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get('/categories/create');

            $response->assertStatus(500);
        // $response->assertSee('Done');
        // $response->assertViewIs('crud.create');
    }
}
