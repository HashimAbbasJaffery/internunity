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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId("internship_id")->constrained()->cascadeOnDelete();
            $table->enum("status", ["applied", "interview", "rejected", "selected"]);
            $table->foreignId("user_id")->constrained()->cascadeOnDelete();
            $table->text("cover_letter")->nullable();
            $table->string("resume")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
