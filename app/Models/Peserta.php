<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    use HasFactory;

    protected $table = 'peserta';

    protected $fillable = [
        'user_id',
        'id_rfid',
        'nama',
        'asal_delegasi',
        'komisi',
        'jenis_kelamin',
    ];


    public function absensi()
{
    return $this->hasMany(\App\Models\Absensi::class, 'peserta_id');
}
public function user()
{
    return $this->belongsTo(User::class);
}


}
