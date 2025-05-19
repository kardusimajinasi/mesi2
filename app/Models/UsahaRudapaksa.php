<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class UsahaRudapaksa extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = 'tbl_usaha_rudapaksa';
    public $timestamps = true;

    protected $fillable = [
        'id',
        'username',
        'success',
        'ip_address',
        'user_agent',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid(); // Buat UUID baru
            }
        });
    }
}
