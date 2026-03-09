<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Level;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $levels = [
            [
                'title'       => 'String of Beginnings',
                'description' => 'The first step in your musical journey',
                'price'       => 25,
                'slug'        => 'string-of-beginnings',
                'order'       => 1,
            ],
            [
                'title'       => 'Tones of Foundation',
                'description' => 'The stage where you build your true musical voice',
                'price'       => 35,
                'slug'        => 'tones-of-foundation',
                'order'       => 2,
            ],
            [
                'title'       => 'Rhythm of Progress',
                'description' => 'For those who wish to move to the professional level',
                'price'       => 45,
                'slug'        => 'rhythm-of-progress',
                'order'       => 3,
            ],
            [
                'title'       => 'Voice of Expression',
                'description' => 'The journey of true expression through music',
                'price'       => 50,
                'slug'        => 'voice-of-expression',
                'order'       => 4,
            ],
            [
                'title'       => 'The Violin Stage',
                'description' => 'The complete journey of a violinist towards the stage and professionalism',
                'price'       => 70,
                'slug'        => 'the-violin-stage',
                'order'       => 5,
            ],
        ];

        foreach ($levels as $level) {
            Level::create($level);
        }
    }
}
