<?php

namespace Tests\Feature;

use App\Models\Dossier;
use App\Models\Report;
use App\Models\User;
use Tests\TestCase;

class DossierTest extends TestCase
{
    public function test_dossiers_are_listed_with_pagination(): void
    {
        Dossier::factory(16)->has(Report::factory(3))->create();

        $this->get("api/v1/dossiers")
            ->assertOk()
            ->assertJsonCount(15, 'data')
            ->assertJsonPath('meta.last_page', 2);
    }

    public function test_user_dossiers_are_listed_with_pagination(): void
    {
        $user = User::factory()->has(Dossier::factory(16))->create();

        $this->get("api/v1/users/$user->id/dossiers")
            ->assertOk()
            ->assertJsonCount(15, 'data')
            ->assertJsonPath('meta.last_page', 2);
    }
}
