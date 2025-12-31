<?php

namespace Database\Factories;

use App\Models\Manga;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Manga>
 */
class MangaFactory extends Factory
{
    protected $model = Manga::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $titles = [
            'The Rising Storm',
            'Eternal Bonds',
            'Shadow Warriors',
            'Cosmic Legends',
            'Mystic Academy',
            'Neon Dreams',
            'Ancient Powers',
            'Future Chronicles',
            'Dark Moon Rising',
            'Light of Hope',
            'Battle Royale',
            'Soul Reapers',
            'Dimension Breakers',
            'Star Guardians',
            'Phantom Thieves',
            'Crimson Blade',
            'Azure Skies',
            'Golden Age',
            'Silver Moon',
            'Emerald Forest',
        ];

        $title = fake()->unique()->randomElement($titles);
        $slug = Str::slug($title);

        $descriptions = [
            'Follow the epic journey of our hero as they face incredible challenges and discover the true meaning of friendship and determination.',
            'A thrilling adventure filled with action, mystery, and unforgettable characters that will keep you on the edge of your seat.',
            'Experience a world where supernatural powers and human emotions collide in this masterfully crafted story.',
            'Join our protagonist on an incredible quest that will test their limits and change their destiny forever.',
            'A captivating tale of courage, sacrifice, and the unbreakable bonds that connect us all.',
        ];

        return [
            'title' => $title,
            'slug' => $slug,
            'cover_image' => null, // Will be handled separately or use placeholder
            'description' => fake()->randomElement($descriptions) . ' ' . fake()->paragraph(2),
            'release_date' => fake()->dateTimeBetween('-10 years', 'now'),
        ];
    }
}

