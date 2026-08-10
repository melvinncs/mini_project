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
        Schema::create('drama', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pengguna')->constrained('pengguna')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('judul', 255);
            $table->string('slug', 255)->unique();
            $table->string('thumbnail', 255)->nullable();
            $table->text('sinopsis')->nullable();
            $table->string('genre', 100)->nullable();
            $table->integer('tahun')->nullable();
            $table->integer('episode')->nullable();
            $table->string('rating', 10)->nullable();
            $table->string('status', 50)->default('Ongoing');
            $table->text('pemeran_utama')->nullable();
            $table->dateTime('diterbitkan_pada')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
