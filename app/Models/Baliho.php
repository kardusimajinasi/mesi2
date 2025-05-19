<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Baliho extends Model
{
    use HasFactory;

    protected $table = 'tbl_baliho';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nama_baliho',
        'lokasi_baliho',
        'foto_baliho',
        'ukuran_baliho',
        'layout_baliho',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function pesanMesi()
    {
        return $this->hasMany(PesanMesi::class, 'lokasi_id');
    }
}
