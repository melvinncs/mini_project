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
        Schema::create('favorit', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pengguna')->constrained('pengguna')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('id_artikel')->constrained('artikel')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
            $table->unique(['id_pengguna', 'id_artikel']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favorit');
    }
};
