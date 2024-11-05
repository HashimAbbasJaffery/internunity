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
        Schema::create('internship_tags', function (Blueprint $table) {
            $table->id();
            $table->foreignId("tag_id")->constrained()->cascadeOnDelete();
            $table->foreignId("internship_id")->constrained()->cascadeOnDelete();
            $table->unique([ "tag_id", "internship_id" ]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('internship_tags');
    }
};