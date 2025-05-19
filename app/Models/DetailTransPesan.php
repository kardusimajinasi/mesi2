<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailTransPesan extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'tbl_detail_trans_pesan';

    protected $fillable = [
        'kode_trans_fk',
        'tanggal',
    ];

    // Relasi dengan tbl_pesan
    public function pesan()
    {
        return $this->belongsTo(PesanMesi::class, 'kode_trans_fk', 'kode_trans');
    }
}
