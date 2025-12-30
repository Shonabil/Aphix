<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eraport extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'agility', 'speed', 'stamina', 'strength',
        'passing', 'dribbling', 'shooting', 'defending',
        'strength_note', 'weakness_note', 'general_note',
        'average_score'
    ];

    // Relasi kebalikannya (Opsional tapi bagus ada)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
