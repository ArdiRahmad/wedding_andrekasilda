<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wa_templates', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Nama template (ex: Formal, Santai)
            $table->text('message'); // Isi pesan
            $table->boolean('is_active')->default(false); // Mana yang dipakai
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wa_templates');
    }
};