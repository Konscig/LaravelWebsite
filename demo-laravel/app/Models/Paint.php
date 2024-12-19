<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // Импортируем трейт SoftDeletes

class Paint extends Model
{
    use SoftDeletes; // Подключаем трейт SoftDeletes

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

    protected $dates = ['deleted_at']; // Указываем поле для хранения даты мягкого удаления

    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('Y-m-d H:i:s');
    }

    public function getUpdatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('Y-m-d H:i:s');
    }

    public function setPaintNameAttribute($value)
    {
        $this->attributes['paint_name'] = trim(substr($value, 0, 255));
    }

    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = trim(substr($value, 0, 1000));
    }

    public function setDetailsAttribute($value)
    {
        $this->attributes['details'] = trim(substr($value, 0, 2000));
    }
}
