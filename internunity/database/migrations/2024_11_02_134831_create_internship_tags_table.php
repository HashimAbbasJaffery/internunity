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
            $table->string("tag_id");
            $table->foreign("tag_id")->references("id")->on("tags")->cascadeOnDelete();
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
