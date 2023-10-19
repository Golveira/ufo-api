<?php

namespace Tests\Feature;

use App\Models\Dossier;
use App\Models\Report;
use Tests\TestCase;

class DossierTest extends TestCase
{
    public function test_dossiers_are_listed_with_pagination(): void
    {
        $dossier = Dossier::factory()->has(Report::factory(3))->create();

        $this->get("api/v1/dossiers")
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('meta.last_page', 1)
            ->assertJsonFragment([
                'id' => $dossier->id,
                'user_id' => $dossier->user->id,
                'title' => $dossier->title,
                'description' => $dossier->description,
                'reports_count' => 3,
                'created_at' => $dossier->created_at,
                'updated_at' => $dossier->updated_at,
                'user' => [
                    'id' => $dossier->user->id,
                    'username' => $dossier->user->username
                ]
            ]);
    }
}
