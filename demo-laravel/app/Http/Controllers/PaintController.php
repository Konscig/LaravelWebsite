<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Paint;

class PaintController extends Controller
{
    public function index()
    {
        $paints = Paint::all();  // Загружаем все объекты Paint
        return view('paints', compact('paints'));  // Передаём переменную $paints в представление
    }

    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'paint_name' => 'required|string|max:255',
            'description' => 'required|string|max:4098',
            'details' => 'required|string|max:4098',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'paint_name.required' => 'Название картины обязательно.',
            'description.required' => 'Описание картины обязательно.',
            'details.required' => 'Детали картины обязательны.',
            'image.required' => 'Изображение картины обязательно.',
            'image.image' => 'Файл должен быть изображением.',
            'image.mimes' => 'Допустимые форматы изображений: jpeg, png, jpg, gif, svg.',
            'image.max' => 'Размер изображения не должен превышать 2MB.',
        ]);

        try {
            // Сохраняем изображение
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $image = $request->file('image');
                $imageName = $image->getClientOriginalName();
                $imagePath = $image->store('images', 'public');
            }

            $paint = new Paint();
            $paint->paint_name = $request->paint_name;
            $paint->description = $request->description;
            $paint->details = $request->details;
            $paint->image_path = $imageName;
            $paint->save();

            return redirect()->back()->with('success', 'Картина успешно добавлена!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Ошибка при сохранении: ' . $e->getMessage());
        }
    }



    public function show(Paint $paint)
    {
        return view('show', compact('paint'));
    }

    public function edit(Paint $paint)
    {
        return view('edit', compact('paint'));
    }

    public function update(Request $request, Paint $paint)
    {
        $validated = $request->validate([
            'paint_name' => 'required|string|max:255',
            'description' => 'required|string|max:4098',
            'details' => 'required|string|max:4098',
        ]);

        $paint->update($validated);

        return redirect()->route('paints');
    }

    public function destroy(Paint $paint)
    {
        $paint->delete();
        return redirect()->route('paints');
    }
}
