<?php

namespace Database\Seeders;

use App\Models\User;
<<<<<<< HEAD
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
=======
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
>>>>>>> 7b5d7dfada9c7047d156582c2bca42c1d0be8c62
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
<<<<<<< HEAD
    use WithoutModelEvents;

=======
>>>>>>> 7b5d7dfada9c7047d156582c2bca42c1d0be8c62
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

<<<<<<< HEAD

        $this->call([
            AdminSeeder::class,
=======
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
>>>>>>> 7b5d7dfada9c7047d156582c2bca42c1d0be8c62
        ]);
    }
}
