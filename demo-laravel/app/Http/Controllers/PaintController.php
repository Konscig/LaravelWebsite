<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paint;

class PaintController extends Controller
{
    public function index()
    {
        // Загружаем только не удалённые мягко объекты
        $paints = Paint::all();
        return view('paints', compact('paints'));
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
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
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
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $imagePath = $request->file('image')->store('images', 'public');
            }

            $paint = new Paint();
            $paint->paint_name = $request->paint_name;
            $paint->description = $request->description;
            $paint->details = $request->details;
            $paint->image_path = $imagePath;
            $paint->save();

            return redirect()->back()->with('success', 'Картина успешно добавлена!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Ошибка при сохранении: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $paint = Paint::findOrFail($id);
        return view('paints.show', compact('paint'));
    }

    public function edit(Paint $paint)
    {
        return view('edit', compact('paint'));
    }

    public function update(Request $request, $id)
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

        $paint = Paint::findOrFail($id);

        $paint->paint_name = $request->input('paint_name');
        $paint->description = $request->input('description');
        $paint->details = $request->input('details');

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('paints', 'public');
            $paint->image_path = $path;
        }

        $paint->save();

        return redirect()->route('paints.index')->with('success', 'Картина успешно обновлена!');
    }

    public function destroy(Paint $paint)
    {
        $paint->delete(); // Мягкое удаление

        return redirect()->route('paints.index')->with('success', 'Картина успешно удалена!');
    }

    public function trashed()
    {
        // Получение мягко удалённых объектов
        $trashedPaints = Paint::onlyTrashed()->get();
        return view('trashed', compact('trashedPaints'));
    }

    public function restore($id)
    {
        $paint = Paint::withTrashed()->findOrFail($id);
        $paint->restore(); // Восстановление мягко удалённого объекта

        return redirect()->route('paints.index')->with('success', 'Картина успешно восстановлена!');
    }

    public function forceDelete($id)
    {
        $paint = Paint::withTrashed()->findOrFail($id);
        $paint->forceDelete(); // Полное удаление из базы данных

        return redirect()->route('trashed')->with('success', 'Картина удалена безвозвратно!');
    }
}
