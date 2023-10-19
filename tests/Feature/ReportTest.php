<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Report;
use Laravel\Sanctum\Sanctum;

class ReportTest extends TestCase
{
    public function test_reports_are_listed_with_pagination(): void
    {
        Report::factory()->count(16)->create();

        $this->get("/api/v1/reports")
            ->assertOk()
            ->assertJsonCount(15, 'data')
            ->assertJsonPath('meta.last_page', 2);
    }

    public function test_user_reports_are_listed_with_pagination(): void
    {
        $user = User::factory()->create();
        $report = Report::factory()->create(['user_id' => $user->id]);

        $this->get("api/v1/users/$user->id/reports")
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('meta.last_page', 1)
            ->assertJsonFragment(['id' => $report->id]);
    }

    public function test_report_is_showed_with_valid_id(): void
    {
        $report = Report::factory()->create();

        $this->get("api/v1/reports/$report->id")
            ->assertOk()
            ->assertJsonFragment(['id' => $report->id]);
    }

    public function test_report_is_not_showed_with_invalid_id(): void
    {
        Report::factory()->create();

        $this->get("api/v1/reports/123456789")
            ->assertNotFound()
            ->assertJson(['message' => 'Resource not found']);
    }

    public function test_unauthenticated_user_cannot_create_report(): void
    {
        $this->postJson("api/v1/reports")
            ->assertUnauthorized();
    }

    public function test_authenticated_user_can_create_report_with_valid_data(): void
    {
        $user = User::factory()->create();
        $reportData = $this->validData();

        Sanctum::actingAs($user);

        $this->postJson("api/v1/reports", $reportData)
            ->assertCreated()
            ->assertJsonFragment($reportData);

        $this->assertDatabaseHas('reports', $reportData);
    }

    public function test_authenticated_user_cannot_create_report_with_invalid_data(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $this->postJson("api/v1/reports", [])
            ->assertUnprocessable();
    }

    public function test_unauthenticated_user_cannot_update_report(): void
    {
        $report = Report::factory()->create();

        $this->putJson("api/v1/reports/$report->id")
            ->assertUnauthorized();
    }

    public function test_authenticated_user_cannot_update_report_from_another_user(): void
    {
        $user = User::factory()->create();
        $report = Report::factory()->create();

        Sanctum::actingAs($user);

        $this->putJson("api/v1/reports/$report->id", $this->validData())
            ->assertForbidden();
    }

    public function test_authenticated_user_can_update_report_with_valid_data(): void
    {
        $user = User::factory()->create();
        $report = Report::factory()->create(['user_id' => $user->id]);
        $reportData = $this->validData();

        Sanctum::actingAs($user);

        $this->putJson("api/v1/reports/$report->id", $reportData)
            ->assertOk()
            ->assertJsonFragment($reportData);

        $this->assertDatabaseHas('reports', $reportData);
    }

    public function test_authenticated_user_cannot_update_report_with_invalid_data(): void
    {
        $user = User::factory()->create();
        $report = Report::factory()->create(['user_id' => $user->id]);

        Sanctum::actingAs($user);

        $this->putJson("api/v1/reports/$report->id", [])
            ->assertUnprocessable();
    }

    public function test_unauthenticated_user_cannot_delete_report(): void
    {
        $report = Report::factory()->create();

        $this->deleteJson("api/v1/reports/$report->id")
            ->assertUnauthorized();
    }

    public function test_authenticated_user_cannot_delete_report_from_another_user(): void
    {
        $user = User::factory()->create();
        $report = Report::factory()->create();

        Sanctum::actingAs($user);

        $this->deleteJson("api/v1/reports/$report->id")
            ->assertForbidden();
    }

    public function test_authenticated_user_can_delete_report(): void
    {
        $user = User::factory()->create();
        $report = Report::factory()->create(['user_id' => $user->id]);

        Sanctum::actingAs($user);

        $this->deleteJson("api/v1/reports/$report->id")
            ->assertNoContent();

        $this->assertDatabaseMissing('reports', ['id' => $report->id]);
    }

    private function validData(): array
    {
        return [
            'summary' => 'report summary',
            'details' => 'report details',
            'country' => 'test country',
            'state' => 'test state',
            'city' => 'test city',
            'lat' => '15.5',
            'long' => '25.5',
            'date' => '2000-01-01',
            'duration' => 5,
            'number_of_observers' => 1,
            'object_shape' => 'round'
        ];
    }
}
