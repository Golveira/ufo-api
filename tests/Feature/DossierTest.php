<?php

namespace Tests\Feature;

use App\Models\Dossier;
use App\Models\Report;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
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

    public function test_unauthenticated_user_cannot_create_dossier(): void
    {
        $this->postJson("api/v1/dossiers")
            ->assertUnauthorized();
    }

    public function test_authenticated_user_can_create_dossier_with_valid_data(): void
    {
        $user = User::factory()->create();
        $dossierData = $this->validData();

        Sanctum::actingAs($user);

        $this->postJson("api/v1/dossiers", $dossierData)
            ->assertCreated()
            ->assertJsonFragment($dossierData);
    }

    public function test_authenticated_user_cannot_create_dossier_with_invalid_data(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $this->postJson("api/v1/dossiers", [])
            ->assertUnprocessable();
    }

    public function test_unauthenticated_user_cannot_update_dossier(): void
    {
        $dossier = Dossier::factory()->create();

        $this->putJson("api/v1/dossiers/$dossier->id")
            ->assertUnauthorized();
    }

    public function test_authenticated_user_can_update_dossier_with_valid_data(): void
    {
        $user = User::factory()->create();
        $dossier = Dossier::factory()->create(['user_id' => $user->id]);
        $dossierData = $this->validData();

        Sanctum::actingAs($user);

        $this->putJson("api/v1/dossiers/$dossier->id", $dossierData)
            ->assertOk()
            ->assertJsonFragment($dossierData);
    }

    public function test_authenticated_user_cannot_update_dossier_with_invalid_data(): void
    {
        $user = User::factory()->create();
        $dossier = Dossier::factory()->create(['user_id' => $user->id]);

        Sanctum::actingAs($user);

        $this->putJson("api/v1/dossiers/$dossier->id", [])
            ->assertUnprocessable();
    }

    public function test_authenticated_user_cannot_update_dossier_from_another_user(): void
    {
        $user = User::factory()->create();
        $dossier = Dossier::factory()->create();
        $dossierData = $this->validData();

        Sanctum::actingAs($user);

        $this->putJson("api/v1/dossiers/$dossier->id", $dossierData)
            ->assertForbidden();
    }

    public function test_unauthenticated_user_cannot_delete_dossier(): void
    {
        $dossier = Dossier::factory()->create();

        $this->deleteJson("api/v1/dossiers/$dossier->id")
            ->assertUnauthorized();
    }

    public function test_authenticated_user_can_delete_dossier(): void
    {
        $user = User::factory()->create();
        $dossier = Dossier::factory()->create(['user_id' => $user->id]);

        Sanctum::actingAs($user);

        $this->deleteJson("api/v1/dossiers/$dossier->id")
            ->assertNoContent();

        $this->assertDatabaseMissing('dossiers', ['id' => $dossier->id]);
    }

    public function test_authenticated_user_cannot_delete_dossier_from_another_user(): void
    {
        $user = User::factory()->create();
        $dossier = Dossier::factory()->create();

        Sanctum::actingAs($user);

        $this->deleteJson("api/v1/dossiers/$dossier->id")
            ->assertForbidden();
    }

    public function test_user_can_add_report_to_dossier(): void
    {
        $user = User::factory()->create();
        $dossier = Dossier::factory()->create(['user_id' => $user->id]);
        $report = Report::factory()->create();

        Sanctum::actingAs($user);

        $this->postJson("api/v1/dossiers/$dossier->id/reports", [
            'report_id' => $report->id
        ])
            ->assertNoContent();

        $dossier->refresh();

        $this->assertTrue($dossier->reports->contains($report));
    }

    public function test_user_cannot_add_report_to_dossier_from_another_user(): void
    {
        $user = User::factory()->create();
        $dossier = Dossier::factory()->create();
        $report = Report::factory()->create();

        Sanctum::actingAs($user);

        $this->postJson("api/v1/dossiers/$dossier->id/reports", [
            'report_id' => $report->id
        ])
            ->assertForbidden();
    }

    public function test_user_can_remove_report_from_dossier(): void
    {
        $user = User::factory()->create();
        $dossier = Dossier::factory()->has(Report::factory())->create(['user_id' => $user->id]);
        $report = $dossier->reports->first();

        Sanctum::actingAs($user);

        $this->deleteJson("api/v1/dossiers/$dossier->id/reports/$report->id")
            ->assertNoContent();

        $dossier->refresh();

        $this->assertTrue($dossier->reports->isEmpty());
    }

    public function test_user_cannot_remove_report_from_dossier_from_another_user(): void
    {
        $user = User::factory()->create();
        $dossier = Dossier::factory()->has(Report::factory())->create();
        $report = $dossier->reports->first();

        Sanctum::actingAs($user);

        $this->deleteJson("api/v1/dossiers/$dossier->id/reports/$report->id")
            ->assertForbidden();
    }

    private function validData(): array
    {
        return [
            'title' => 'dossier title',
            'description' => 'dossier description'
        ];
    }
}
