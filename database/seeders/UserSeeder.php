<?php

namespace Database\Seeders;

use App\Models\Dossier;
use App\Models\Image;
use App\Models\Report;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()
            ->count(10)
            ->has(
                Report::factory()
                    ->count(3)
                    ->has(Image::factory()->count(1))
            )
            ->create();

        User::factory()
            ->count(10)
            ->has(
                Dossier::factory()
                    ->count(3)
                    ->has(
                        Report::factory()
                            ->count(3)
                            ->has(Image::factory()->count(1))
                    )
            )
            ->create();
    }
}
