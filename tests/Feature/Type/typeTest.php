<?php

namespace Tests\Feature\type;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class typeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(302);
    }

    /**
     * A basic feature test example.
     */
    public function test_types_index(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get('/types');

        $response->assertOk();
    }
}
