<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained();
            $table->string('summary');
            $table->string('country');
            $table->string('state');
            $table->string('city');
            $table->decimal('lat', 10, 8);
            $table->decimal('long', 11, 8);
            $table->dateTime('date');
            $table->integer('duration');
            $table->string('object_shape');
            $table->integer('number_of_observers');
            $table->text('details');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
