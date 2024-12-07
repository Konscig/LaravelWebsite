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

    // Мутатор для поля image_path (если необходимо изменить путь изображения перед сохранением)
    public function setImagePathAttribute($value)
    {
        // Пример: если путь изображения не пустой, добавляем префикс к пути
        if ($value) {
            $this->attributes['image_path'] = 'resources/images/' . $value;
        }
    }

    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('Y-m-d H:i:s');
    }

    public function getUpdatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('Y-m-d H:i:s');
    }

    // Геттер для поля image_path (если нужно обрабатывать путь при извлечении)
    public function getImagePathAttribute($value)
    {
        return $value ? asset($value) : null;
    }
}
