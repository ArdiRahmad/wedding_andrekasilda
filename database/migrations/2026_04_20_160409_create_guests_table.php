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
        Schema::create('guests', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama tamu
            $table->string('whatsapp_number')->nullable(); // Nomor WA untuk blast
            $table->string('category')->nullable(); // Kategori (Keluarga, Teman, dll)
            $table->enum('rsvp_status', ['pending', 'hadir', 'tidak_hadir'])->default('pending'); // Status RSVP
            $table->integer('pax')->default(0); // Jumlah orang yang dibawa
            $table->text('message')->nullable(); // Ucapan dari tamu
            $table->boolean('is_wishes')->default(false); 
            $table->boolean('is_wa_sent')->default(false); // Status apakah WA sudah dikirim
            $table->string('unique_code')->unique()->nullable(); // Kode unik untuk URL undangan
            $table->string('side')->default('groom'); // Sisi (Mempelai Pria atau Mempelai Wanita)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guests');
    }
};
