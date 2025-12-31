<?php

namespace Database\Seeders;

use App\Models\Chapter;
use App\Models\ChapterPage;
use App\Models\FaqCategory;
use App\Models\FaqItem;
use App\Models\Manga;
use App\Models\News;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create default admin user
        User::create([
            'name' => 'Admin User',
            'username' => 'admin',
            'email' => 'admin@ehb.be',
            'password' => Hash::make('Password!321'),
            'is_admin' => true,
            'email_verified_at' => now(),
        ]);

        // Create some regular users
        User::factory(5)->create([
            'is_admin' => false,
        ]);

        // Create manga with realistic data
        $mangas = [
            [
                'title' => 'One Piece',
                'slug' => 'one-piece',
                'description' => 'Monkey D. Luffy and his pirate crew explore the Grand Line in search of the world\'s ultimate treasure known as "One Piece" in order to become the next Pirate King. This epic adventure spans decades and features incredible world-building, memorable characters, and thrilling battles.',
                'release_date' => '1997-07-22',
                'cover_image' => 'manga-covers/one-piece.jpg',
            ],
            [
                'title' => 'Naruto',
                'slug' => 'naruto',
                'description' => 'Naruto Uzumaki, a young ninja who seeks recognition from his peers and dreams of becoming the Hokage, the leader of his village. Follow his journey as he trains, makes friends, and faces powerful enemies in this action-packed series.',
                'release_date' => '1999-09-21',
                'cover_image' => 'manga-covers/naruto.jpg',
            ],
            [
                'title' => 'Attack on Titan',
                'slug' => 'attack-on-titan',
                'description' => 'Humanity fights for survival against the terrifying Titans in this dark and intense series. Eren Yeager joins the military to avenge his mother and discover the truth behind the Titans\' existence.',
                'release_date' => '2009-09-09',
                'cover_image' => 'manga-covers/attack-on-titan.jpg',
            ],
            [
                'title' => 'Demon Slayer',
                'slug' => 'demon-slayer',
                'description' => 'After his family is slaughtered and his sister turned into a demon, Tanjiro Kamado becomes a demon slayer to find a cure for his sister and avenge his family. Beautiful art and emotional storytelling.',
                'release_date' => '2016-02-15',
                'cover_image' => 'manga-covers/demon-slayer.jpg',
            ],
            [
                'title' => 'My Hero Academia',
                'slug' => 'my-hero-academia',
                'description' => 'In a world where most people have superpowers called "Quirks," Izuku Midoriya dreams of becoming a hero despite being born without powers. He enrolls in U.A. High School to train as a professional hero.',
                'release_date' => '2014-07-07',
                'cover_image' => 'manga-covers/my-hero-academia.jpg',
            ],
            [
                'title' => 'Death Note',
                'slug' => 'death-note',
                'description' => 'Light Yagami finds a mysterious notebook that can kill anyone whose name is written in it. He decides to use it to rid the world of criminals, but a brilliant detective named L is determined to stop him.',
                'release_date' => '2003-12-01',
                'cover_image' => 'manga-covers/death-note.jpg',
            ],
            [
                'title' => 'Jujutsu Kaisen',
                'slug' => 'jujutsu-kaisen',
                'description' => 'Yuji Itadori joins his school\'s Occult Club and encounters a cursed object. When his friends are attacked, he swallows the object and becomes a vessel for a powerful curse. He must now train as a jujutsu sorcerer.',
                'release_date' => '2018-03-05',
                'cover_image' => 'manga-covers/jujutsu-kaisen.jpg',
            ],
            [
                'title' => 'Chainsaw Man',
                'slug' => 'chainsaw-man',
                'description' => 'Denji is a young man who makes a contract with his pet devil Pochita, becoming Chainsaw Man. He joins the Public Safety Devil Hunters to fight devils and achieve his simple dream of living a normal life.',
                'release_date' => '2018-12-03',
                'cover_image' => 'manga-covers/chainsaw-man.jpg',
            ],
            [
                'title' => 'Spy x Family',
                'slug' => 'spy-x-family',
                'description' => 'A spy on an undercover mission forms a fake family with an assassin and a telepath, not knowing each other\'s true identities. A heartwarming comedy about an unusual family trying to live together.',
                'release_date' => '2019-03-25',
                'cover_image' => 'manga-covers/spy-x-family.jpg',
            ],
            [
                'title' => 'One Punch Man',
                'slug' => 'one-punch-man',
                'description' => 'Saitama is a hero who can defeat any opponent with a single punch, but his incredible strength has left him bored and unchallenged. He seeks a worthy opponent while dealing with the mundane aspects of hero life.',
                'release_date' => '2012-06-14',
                'cover_image' => 'manga-covers/one-punch-man.jpg',
            ],
            [
                'title' => 'Dragon Ball Z',
                'slug' => 'dragon-ball-z',
                'description' => 'Goku and his friends defend Earth against powerful enemies including Saiyans, Frieza, Cell, and Majin Buu. Epic battles, transformations, and the quest for greater power define this legendary series.',
                'release_date' => '1984-12-03',
                'cover_image' => 'manga-covers/dragon-ball-z.jpg',
            ],
            [
                'title' => 'Bleach',
                'slug' => 'bleach',
                'description' => 'Ichigo Kurosaki gains the powers of a Soul Reaper and must protect the living world from evil spirits and guide souls to the afterlife. An action-packed series with unique sword-based combat.',
                'release_date' => '2001-08-07',
                'cover_image' => 'manga-covers/bleach.jpg',
            ],
        ];

        foreach ($mangas as $mangaData) {
            Manga::create($mangaData);
        }

        // Create additional random mangas
        Manga::factory(8)->create();

        // Create news items
        $newsItems = [
            [
                'title' => 'Welcome to MangaVerse - Your Ultimate Manga Destination',
                'content' => 'We are excited to launch MangaVerse, a new platform dedicated to manga enthusiasts worldwide. Our mission is to provide you with the best reading experience and keep you updated with the latest releases and news from the manga world.

Whether you\'re a long-time fan or just discovering the world of manga, MangaVerse has something for everyone. Explore our extensive library, discover new series, and connect with fellow manga lovers.

Stay tuned for regular updates, exclusive content, and exciting features coming soon!',
                'published_at' => now()->subDays(30),
            ],
            [
                'title' => 'Top 10 Must-Read Manga Series of 2024',
                'content' => 'As we dive deeper into 2024, we\'ve compiled a list of the most exciting and popular manga series that you absolutely need to check out. From action-packed adventures to heartwarming slice-of-life stories, this list has something for every reader.

Our community has been buzzing about these series, and we wanted to share them with you. Each series brings something unique to the table, whether it\'s incredible artwork, compelling storytelling, or unforgettable characters.

Don\'t miss out on these incredible stories that are shaping the manga landscape this year!',
                'published_at' => now()->subDays(15),
            ],
            [
                'title' => 'New Feature: Enhanced Reading Experience',
                'content' => 'We\'ve been working hard behind the scenes to improve your reading experience on MangaVerse. Our latest update includes several exciting features:

- Enhanced page navigation for smoother reading
- Improved image quality and loading speeds
- Better mobile responsiveness
- New bookmark and favorites system
- Reading history tracking

We hope these improvements make your manga reading experience even more enjoyable. As always, we value your feedback and are constantly working to make MangaVerse better.',
                'published_at' => now()->subDays(7),
            ],
        ];

        foreach ($newsItems as $news) {
            News::create($news);
        }

        // Create additional random news
        News::factory(5)->create();

        // Create FAQ categories and items
        $generalCategory = FaqCategory::create([
            'name' => 'General Questions',
            'description' => 'Common questions about MangaVerse',
        ]);

        FaqItem::create([
            'faq_category_id' => $generalCategory->id,
            'question' => 'What is MangaVerse?',
            'answer' => 'MangaVerse is a comprehensive platform for manga enthusiasts. We provide a curated collection of manga series, latest news, and a community for manga lovers to connect and share their passion.',
        ]);

        FaqItem::create([
            'faq_category_id' => $generalCategory->id,
            'question' => 'How do I create an account?',
            'answer' => 'Creating an account is easy! Simply click on the "Register" button in the top right corner, fill in your information, and you\'ll be ready to start exploring our manga collection and connecting with the community.',
        ]);

        FaqItem::create([
            'faq_category_id' => $generalCategory->id,
            'question' => 'Is MangaVerse free to use?',
            'answer' => 'Yes! MangaVerse is completely free to use. You can browse our manga collection, read news, and participate in the community without any cost. We believe manga should be accessible to everyone.',
        ]);

        $readingCategory = FaqCategory::create([
            'name' => 'Reading & Features',
            'description' => 'Questions about reading manga and using features',
        ]);

        FaqItem::create([
            'faq_category_id' => $readingCategory->id,
            'question' => 'How do I find a specific manga?',
            'answer' => 'You can use the search function on the manga page to search by title or description. You can also browse through our collection and use filters to find manga by genre or sort by different criteria like latest updates or popularity.',
        ]);

        FaqItem::create([
            'faq_category_id' => $readingCategory->id,
            'question' => 'Can I bookmark my favorite manga?',
            'answer' => 'Yes! Once you\'re logged in, you can bookmark your favorite manga series. This feature helps you keep track of the manga you want to read or are currently following.',
        ]);

        $accountCategory = FaqCategory::create([
            'name' => 'Account & Profile',
            'description' => 'Questions about user accounts and profiles',
        ]);

        FaqItem::create([
            'faq_category_id' => $accountCategory->id,
            'question' => 'How do I update my profile?',
            'answer' => 'You can update your profile by clicking on your profile picture in the navigation bar and selecting "Settings", or by visiting your profile page. You can update your username, birthday, profile photo, and "About Me" section.',
        ]);

        FaqItem::create([
            'faq_category_id' => $accountCategory->id,
            'question' => 'I forgot my password. What should I do?',
            'answer' => 'No worries! Click on "Login" and then select "Forgot your password?" You\'ll receive an email with instructions to reset your password. Make sure to check your spam folder if you don\'t see the email.',
        ]);

        // Create chapters for some mangas
        $mangaTitles = ['one-piece', 'naruto', 'attack-on-titan', 'demon-slayer', 'my-hero-academia'];
        
        foreach ($mangaTitles as $slug) {
            $manga = Manga::where('slug', $slug)->first();
            if ($manga) {
                // Create 3-5 chapters with VF and VO versions
                $chapterCount = rand(3, 5);
                
                for ($i = 1; $i <= $chapterCount; $i++) {
                    // VF version
                    $vfChapter = Chapter::create([
                        'manga_id' => $manga->id,
                        'chapter_number' => $i,
                        'title' => $i === 1 ? 'The Beginning' : ($i === $chapterCount ? 'The Climax' : null),
                        'language' => 'VF',
                        'page_count' => rand(15, 25),
                        'is_published' => true,
                        'published_at' => now()->subDays(rand(1, 30)),
                        'views' => rand(100, 5000),
                    ]);
                    
                    // Create pages for VF chapter (placeholder images)
                    for ($page = 1; $page <= $vfChapter->page_count; $page++) {
                        ChapterPage::create([
                            'chapter_id' => $vfChapter->id,
                            'page_number' => $page,
                            'image_path' => "chapters/placeholder-1.jpg", // Use same placeholder for all
                        ]);
                    }
                    
                    // VO version (sometimes)
                    if (rand(0, 1)) {
                        $voChapter = Chapter::create([
                            'manga_id' => $manga->id,
                            'chapter_number' => $i,
                            'title' => $i === 1 ? 'The Beginning' : ($i === $chapterCount ? 'The Climax' : null),
                            'language' => 'VO',
                            'page_count' => rand(15, 25),
                            'is_published' => true,
                            'published_at' => now()->subDays(rand(1, 30)),
                            'views' => rand(50, 3000),
                        ]);
                        
                        // Create pages for VO chapter
                        for ($page = 1; $page <= $voChapter->page_count; $page++) {
                            ChapterPage::create([
                                'chapter_id' => $voChapter->id,
                                'page_number' => $page,
                                'image_path' => "chapters/placeholder-1.jpg",
                            ]);
                        }
                    }
                }
            }
        }

        $this->command->info('Database seeded successfully!');
        $this->command->info('Admin user created: admin@ehb.be / Password!321');
        $this->command->info('Chapters created for popular manga series!');
    }
}
