<?php

namespace Tests\Feature;

use App\Models\Report;
use Tests\TestCase;

class ReportFilterTest extends TestCase
{
    public function test_reports_are_filtered_by_keywords(): void
    {
        Report::factory()->create(['summary' => 'I saw a ufo']);
        Report::factory()->create(['details' => 'I also saw a ufo']);
        Report::factory()->create(['summary' => "I don't know what I saw"]);

        $this->get('api/v1/reports?keywords=ufo')
            ->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJsonPath('data.0.summary', 'I saw a ufo')
            ->assertJsonPath('data.1.details', 'I also saw a ufo');
    }

    public function test_reports_are_filtered_by_country(): void
    {
        Report::factory()->create(['country' => 'brazil']);
        Report::factory()->create(['country' => 'brazil']);
        Report::factory()->create(['country' => 'argentina']);

        $this->get('api/v1/reports?country=brazil')
            ->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJsonPath('data.0.country', 'brazil')
            ->assertJsonPath('data.1.country', 'brazil');
    }

    public function test_reports_are_filtered_by_state(): void
    {
        Report::factory()->create(['state' => 'miami']);
        Report::factory()->create(['state' => 'miami']);
        Report::factory()->create(['state' => 'california']);

        $this->get('api/v1/reports?state=miami')
            ->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJsonPath('data.0.state', 'miami')
            ->assertJsonPath('data.1.state', 'miami');
    }

    public function test_reports_are_filtered_by_city(): void
    {
        Report::factory()->create(['city' => 'new york']);
        Report::factory()->create(['city' => 'new york']);
        Report::factory()->create(['city' => 'chicago']);

        $this->get('api/v1/reports?city=new york')
            ->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJsonPath('data.0.city', 'new york')
            ->assertJsonPath('data.1.city', 'new york');
    }

    public function test_reports_are_filtered_by_date_from(): void
    {
        Report::factory()->create(['date' => '2000-01-01']);
        Report::factory()->create(['date' => '2010-01-01']);
        Report::factory()->create(['date' => '2020-01-01']);

        $this->get('api/v1/reports?dateFrom=2010-01-01')
            ->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJsonPath('data.0.date', '2010-01-01')
            ->assertJsonPath('data.1.date', '2020-01-01');
    }

    public function test_reports_are_filtered_by_date_to(): void
    {
        Report::factory()->create(['date' => '2000-01-01']);
        Report::factory()->create(['date' => '2010-01-01']);
        Report::factory()->create(['date' => '2020-01-01']);

        $this->get('api/v1/reports?dateTo=2010-01-01')
            ->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJsonPath('data.0.date', '2000-01-01')
            ->assertJsonPath('data.1.date', '2010-01-01');
    }

    public function test_reports_are_sorted_by_date_in_asc_order(): void
    {
        Report::factory()->create(['date' => '2000-01-01']);
        Report::factory()->create(['date' => '2010-01-01']);
        Report::factory()->create(['date' => '2020-01-01']);

        $this->get('api/v1/reports?sortBy=date&sortOrder=asc')
            ->assertOk()
            ->assertJsonCount(3, 'data')
            ->assertJsonPath('data.0.date', '2000-01-01')
            ->assertJsonPath('data.1.date', '2010-01-01')
            ->assertJsonPath('data.2.date', '2020-01-01');
    }

    public function test_reports_are_sorted_by_date_in_desc_order(): void
    {
        Report::factory()->create(['date' => '2000-01-01']);
        Report::factory()->create(['date' => '2010-01-01']);
        Report::factory()->create(['date' => '2020-01-01']);

        $this->get('api/v1/reports?sortBy=date&sortOrder=desc')
            ->assertOk()
            ->assertJsonCount(3, 'data')
            ->assertJsonPath('data.0.date', '2020-01-01')
            ->assertJsonPath('data.1.date', '2010-01-01')
            ->assertJsonPath('data.2.date', '2000-01-01');
    }
}
