<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Guest extends Model
{
    use HasFactory;

    /**
     * Properti ini menentukan kolom mana saja yang boleh diisi secara massal
     */
    protected $fillable = [
        'name',
        'whatsapp_number',
        'category',
        'rsvp_status',
        'pax',
        'side',
        'message',
        'is_wa_sent',
        'unique_code',
        'is_wishes'
    ];

    protected static function booted()
    {
        static::creating(function ($guest) {
            if (empty($guest->unique_code)) {
                do {
                    $code = Str::random(8);
                } while (self::where('unique_code', $code)->exists()); // Cek di DB
                
                $guest->unique_code = $code;
            }
        });
    }
}