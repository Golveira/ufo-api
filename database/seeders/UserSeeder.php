<?php

namespace Database\Seeders;

use App\Models\Bookmark;
use App\Models\Dossier;
use App\Models\User;
use App\Models\Image;
use App\Models\Like;
use App\Models\Report;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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
            ->has(
                Bookmark::factory()
                    ->count(3)
                    ->report()
            )
            ->has(
                Bookmark::factory()
                    ->count(3)
                    ->dossier()
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
