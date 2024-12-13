<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paint extends Model
{
    // Указываем таблицу, если имя не соответствует стандартному (по имени модели)
    protected $table = 'paints';

    protected $primaryKey = 'id';

    // Указываем поля, которые могут быть массово присвоены
    protected $fillable = [
        'paint_name',
        'description',
        'details',
        'image_path'
    ];

    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('Y-m-d H:i:s');
    }

    public function getUpdatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('Y-m-d H:i:s');
    }
}
