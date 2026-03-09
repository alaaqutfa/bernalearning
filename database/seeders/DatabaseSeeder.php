<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(LevelSeeder::class);

        User::create([
            'name'     => 'Berna',
            'email'    => 'admin@berna-violin.art',
            'phone'    => null,
            'password' => bcrypt('B123456b@'),
            'is_admin' => true,
        ]);
        User::create([
            'name'     => 'Alaa',
            'email'    => 'alaa@berna-violin.art',
            'phone'    => null,
            'password' => bcrypt('A123456a@2001'),
            'is_admin' => true,
        ]);
    }
}
