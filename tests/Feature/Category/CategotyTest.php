<?php

namespace Tests\Feature\Category;

use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use App\Models\Type;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategotyTest extends TestCase
{
    use RefreshDatabase;

    public function data() {
        // Create a new user
        $user = User::factory()->create();

        $type = Type::create(['name' => 'New Type']);

        $category = Category::create([
            'name' => 'New Category',
            'is_parent' => '1',
            'type_id' => $type->id
        ]);

        $updatedCategory = Category::create([
            'name' => 'New Category 2',
            'is_parent' => '0',
            'type_id' => $type->id
        ]);

        return [
            'user' => $user,
            'type' => $type,
            'category' => $category,
            'updatedCategory' => $updatedCategory
        ];
    }

    /**
     * A basic feature test example.
     */
    public function test_index(): void
    {
        // Create a new user
        $user = User::factory()->create();

        // Login the user
        $this->actingAs($user);

        $response = $this->get('/categories');

        $response->assertSee($user->name); // done
    }

    public function test_show(): void
    {
        // Login the user
        $this->actingAs($this->data()['user']);

        $response = $this->get('/categories/'. $this->data()['category']->id);

        $response->assertSee('Category');
    }

    public function test_create(): void
    {
        // Login the user
        $this->actingAs($this->data()['user']);


        $response = $this->get('categories/create');

        $response->assertSee('Categories');
    }

    public function test_store(): void
    {
        // Login the user
        $this->actingAs($this->data()['user']);

        // Send a POST request to the create category route
        $response = $this->post(route('categories.store'), [
            $this->data()['category']
        ]);

        // Assert that the response is a redirect
        $response->assertStatus(302);
        $response->assertRedirect();

        // Assert that the category was created
        $this->assertDatabaseHas('categories', [
            'name' => 'New Category',
            'is_parent' => '1',
            'type_id' => $this->data()['type']->id
        ]);
    }

    public function test_update(): void
    {
        // Login the user
        $this->actingAs($this->data()['user']);

        // Send a POST request to the create category route
        $response = $this->put(route('categories.update', $this->data()['category']->id), [
            $this->data()['updatedCategory']
        ]);

        // Assert that the response is a redirect
        $response->assertStatus(302);
        $response->assertRedirect();

        // Assert that the category was created
        $this->assertDatabaseHas('categories', [
            'name' => 'New Category 2',
            'is_parent' => '0',
            'type_id' => $this->data()['type']->id
        ]);
    }
}
