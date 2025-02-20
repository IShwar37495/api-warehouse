<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Api extends Model
{
    use HasFactory;
    protected $table = 'api';
    protected $fillable = [ 'id','name', 'description'];
    protected $hidden = ['created_at', 'updated_at'];
    protected $casts = ['id' => 'string'];
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = true;

     protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = Str::uuid();
            }
        });
    }
}
