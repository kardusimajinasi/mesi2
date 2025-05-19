<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    protected $table = 'tbl_lvl';

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
        'level',
    ];

    public function setlevelAttribute($value)
    {
        $this->attributes['level'] = strtoupper($value);
    }

    public function users()
    {
        return $this->hasMany(User::class, 'level_id', 'id');
    }
}
