<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class PesanMesi extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'tbl_pesan';

    protected $fillable = [
        'baliho_id', 'user_id', 'instansi_id', 'level_id'
    ];

    // Relasi dengan tabel Baliho
    public function baliho()
    {
        return $this->belongsTo(Baliho::class);
    }

    // Relasi dengan tabel User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi dengan tabel Instansi
    public function instansi()
    {
        return $this->belongsTo(Instansi::class);
    }

    // Relasi dengan tabel Level
    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransPesan::class, 'kode_trans_fk', 'kode_trans');
    }
}
