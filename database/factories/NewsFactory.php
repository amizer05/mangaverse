<?php

namespace Database\Factories;

use App\Models\News;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\News>
 */
class NewsFactory extends Factory
{
    protected $model = News::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $titles = [
            'New Chapter Release: Exciting Developments Ahead',
            'MangaVerse Announces Partnership with Major Publishers',
            'Community Spotlight: Top Manga of the Month',
            'Upcoming Events: Manga Convention 2024',
            'New Feature: Enhanced Reading Experience',
            'Author Interview: Behind the Scenes of Popular Series',
            'Weekly Update: Latest Additions to Our Library',
            'Special Event: Manga Reading Marathon',
        ];

        $contents = [
            'We are thrilled to announce the release of the latest chapter in one of our most popular series. Fans have been eagerly waiting for this moment, and we believe this chapter will exceed all expectations. Stay tuned for more updates!',
            'In a groundbreaking move, MangaVerse has partnered with several major manga publishers to bring you exclusive content and early access to new releases. This partnership will significantly expand our library and improve the reading experience for all our users.',
            'This month, our community has been buzzing about some incredible manga series. From action-packed adventures to heartwarming stories, discover what our readers are loving right now.',
            'Mark your calendars! The annual Manga Convention is coming to town, and we will be there with exclusive merchandise, author meet-and-greets, and special announcements. Don\'t miss out on this incredible event!',
            'We\'ve been working hard to improve your reading experience. Our latest update includes enhanced page navigation, better image quality, and a smoother reading interface. Try it out and let us know what you think!',
        ];

        return [
            'title' => fake()->randomElement($titles),
            'image' => null, // Can be added later with actual images
            'content' => fake()->randomElement($contents) . "\n\n" . fake()->paragraphs(3, true),
            'published_at' => fake()->dateTimeBetween('-2 months', 'now'),
        ];
    }
}














