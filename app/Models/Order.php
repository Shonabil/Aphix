<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'photo_ids', // Disimpan sebagai string "1,2,5"
        'total_price',
        'status',
        'payment_proof'
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Aksesor Custom: Mengambil detail Foto berdasarkan ID yang disimpan
    // Cara panggil di blade: $order->photos_list
    public function getPhotosListAttribute()
    {
        if (!$this->photo_ids) return collect([]);

        // Ubah string "1,2,5" menjadi array [1, 2, 5]
        $ids = explode(',', $this->photo_ids);

        // Ambil data foto dari database
        return Photo::whereIn('id', $ids)->get();
    }
}
