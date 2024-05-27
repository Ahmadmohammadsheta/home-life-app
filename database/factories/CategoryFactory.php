<?php

namespace Database\Factories;

use App\Models\Type;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Repository\CategoryRepositoryInterface;
use App\Repository\Eloquent\CategoryRepository;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CategoryFactory extends Factory
{
    /**
     * Factory constructor method
     */
    public function allParentsIds(int $id) {
        $repository = new CategoryRepository(new category);
        return $repository->allParentsIds($id);
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->words(3, true);
        $name = fake()->department; // mbezhanov/laravel-faker-provider package
        $parent_id = Category::inRandomOrder()->whereIsParent(true)->first()->id;
        $repository = new CategoryRepository(new category);
        $all_parents_ids = $repository->allParentsIds($parent_id);
        $slug = Str::slug($name);
        $image = fake()->imageUrl();

        return [
            'name' => $name,
            'parent_id' => $parent_id,
            'all_parents_ids' => $all_parents_ids,
            'is_parent' => rand(0, 1),
            'type_id' => Type::inRandomOrder()->first()->id,
            'created_at' => now(),
        ];
    }
}
