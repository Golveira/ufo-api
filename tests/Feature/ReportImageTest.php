<?php

namespace Tests\Feature;

use App\Exceptions\MaxImagesUploadException;
use App\Models\Image;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ReportImageTest extends TestCase
{
    public function test_unauthenticated_user_cannot_upload_images_to_a_report()
    {
        Storage::fake('public');

        $report = Report::factory()->create();

        $this->postJson("api/v1/reports/$report->id/images", [
            'images' => [UploadedFile::fake('ufo.jpg')],
        ])
            ->assertUnauthorized();
    }

    public function test_user_cannot_upload_images_to_a_report_from_another_user(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $anotherUser = User::factory()->create();
        $report = Report::factory()->create(['user_id' => $anotherUser->id]);

        Sanctum::actingAs($user);

        $this->postJson("api/v1/reports/$report->id/images", [
            'images' => [UploadedFile::fake()->image('ufo.jpg')],
        ])
            ->assertForbidden();
    }

    public function test_user_cannot_upload_more_than_10_images_to_a_report(): void
    {
        Storage::fake('public');

        $this->withoutExceptionHandling();

        $user = User::factory()->create();
        $report = Report::factory()
            ->has(Image::factory(9))
            ->create(['user_id' => $user->id]);

        Sanctum::actingAs($user);

        $this->expectException(MaxImagesUploadException::class);

        $this->postJson("api/v1/reports/$report->id/images", [
            'images' => [
                UploadedFile::fake()->image('ufo1.jpg'),
                UploadedFile::fake()->image('ufo2.jpg'),
            ],
        ]);
    }

    public function test_user_can_upload_images_to_own_report(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $report = Report::factory()->create(['user_id' => $user->id]);

        Sanctum::actingAs($user);

        $this->postJson("api/v1/reports/$report->id/images", [
            'images' => [
                UploadedFile::fake()->image('ufo1.jpg'),
                UploadedFile::fake()->image('ufo2.jpg'),
            ],
        ]);

        $this->assertCount(2, $report->images);
        Storage::disk('public')
            ->assertExists($report->images->first()->path)
            ->assertExists($report->images->last()->path);
    }

    public function test_user_can_delete_image_from_own_report(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $report = Report::factory()->create(['user_id' => $user->id]);
        $image_path = UploadedFile::fake()->image('ufo.jpg')->store('reports', 'public');
        $image = $report->images()->create(['path' => $image_path]);

        Sanctum::actingAs($user);

        $this->deleteJson("api/v1/reports/$report->id/images/$image->id");

        $this->assertCount(0, $report->refresh()->images);
        Storage::disk('public')->assertMissing($image_path);
    }
}
