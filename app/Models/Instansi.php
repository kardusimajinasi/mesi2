<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instansi extends Model
{
    use HasFactory;

    protected $table = 'tbl_instansi';
    public $incrementing = false;
    protected $keyType = 'string';

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = (string) \Illuminate\Support\Str::uuid();
        });
    }

    protected $fillable = [
        'id',
        'instansi',
    ];

    public function setlevelAttribute($value)
    {
        $this->attributes['instansi'] = strtoupper($value);
    }

    public function users()
    {
        return $this->hasMany(User::class, 'instansi_id');
    }
}
