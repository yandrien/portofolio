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
        Schema::create('visitor_summaries', function (Blueprint $table) {
            $table->id();
			$table->unsignedInteger('total_visitors')->default(1856); // Nilai awal backup pengunjung
            $table->unsignedInteger('total_hits')->default(9297);     // Nilai awal backup klik/hits
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitor_summaries');
    }
};
