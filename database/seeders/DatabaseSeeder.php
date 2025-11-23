<?php

namespace Database\Seeders;

use App\Models\Participant;
use App\Models\Classes;
use App\Models\Enrollment;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $participants = [
            [
                'name' => 'Patrick Steven',
                'email' => 'john.doe@email.com',
                'phone' => '081234567890',
                'address' => 'Jl. Merdeka No. 123, Jakarta',
            ],
            [
                'name' => 'Hayya u',
                'email' => 'jane.smith@email.com',
                'phone' => '081234567891',
                'address' => 'Jl. Sudirman No. 456, Bandung',
            ],
            [
                'name' => 'Rafi Naya',
                'email' => 'michael.j@email.com',
                'phone' => '081234567892',
                'address' => 'Jl. Gatot Subroto No. 789, Surabaya',
            ],
            [
                'name' => 'Priscillia King',
                'email' => 'sarah.w@email.com',
                'phone' => '081234567893',
                'address' => 'Jl. Ahmad Yani No. 321, Yogyakarta',
            ],
            [
                'name' => 'Daniel Fernando',
                'email' => 'david.b@email.com',
                'phone' => '081234567894',
                'address' => 'Jl. Diponegoro No. 654, Semarang',
            ],
        ];

        foreach ($participants as $participantData) {
            Participant::create($participantData);
        }

        $classes = [
            [
                'name' => 'Graphic Design Fundamentals',
                'description' => 'Learn the basics of graphic design including color theory, typography, and layout principles. Perfect for beginners.',
                'instructor' => 'Amanda Chen',
            ],
            [
                'name' => 'Web Development Basic',
                'description' => 'Introduction to HTML, CSS, and JavaScript. Build your first responsive website from scratch.',
                'instructor' => 'Robert Martinez',
            ],
            [
                'name' => 'Video Editing Masterclass',
                'description' => 'Master video editing with Adobe Premiere Pro and After Effects. Create professional videos.',
                'instructor' => 'Emily Thompson',
            ],
            [
                'name' => 'Public Speaking Excellence',
                'description' => 'Develop confidence and skills for effective public speaking and presentations.',
                'instructor' => 'James Wilson',
            ],
            [
                'name' => 'Digital Marketing Strategy',
                'description' => 'Learn SEO, social media marketing, and content strategy for digital success.',
                'instructor' => 'Lisa Anderson',
            ],
        ];

        foreach ($classes as $classData) {
            Classes::create($classData);
        }

        $enrollments = [
            ['participant_id' => 1, 'class_id' => 1],
            ['participant_id' => 1, 'class_id' => 2],
            ['participant_id' => 2, 'class_id' => 1], 
            ['participant_id' => 2, 'class_id' => 3], 
            ['participant_id' => 2, 'class_id' => 4],
            ['participant_id' => 3, 'class_id' => 2],
            ['participant_id' => 3, 'class_id' => 5], 
            ['participant_id' => 4, 'class_id' => 4], 
            ['participant_id' => 5, 'class_id' => 3],
            ['participant_id' => 5, 'class_id' => 5],
        ];

        foreach ($enrollments as $enrollmentData) {
            Enrollment::create(array_merge($enrollmentData, [
                'enrolled_at' => now()->subDays(rand(1, 30)),
            ]));
        }
    }
}