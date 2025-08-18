<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama',
        'deskripsi',
        'komisi',
    ];

    public static function getKomisiList(): array
    {
        return ['organisasi', 'program-kerja', 'rekomendasi'];
    }
    public function user()
{
    return $this->belongsTo(User::class);
}

}
