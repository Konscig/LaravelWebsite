<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Paint;

class PaintController extends Controller
{
    public function index()
    {
        $objects = Paint::all();
        return view('paints.index', compact('objects'));
    }

    public function create()
    {
        return view('paints.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'paint_name' => 'required|string|max:255',
            'description' => 'required|string',
            'details' => 'required|string|max:4096',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $paint = new Paint();
        $paint->paint_name = $request->paint_name;
        $paint->description = $request->description;
        $paint->details = $request->details;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('paints', 'public');
            $paint->image_path = $imagePath;
        }

        $paint->save();

        return redirect()->route('paints.index');
    }

    public function show(Paint $object)
    {
        return view('paints.show', compact('object'));
    }

    public function edit(Paint $object)
    {
        return view('paints.edit', compact('object'));
    }

    public function update(Request $request, Paint $object)
    {
        $validated = $request->validate([
            'paint_name' => 'required|string|max:255',
            'description' => 'required|string',
            'details' => 'required|string',
        ]);

        $object->update($validated);

        return redirect()->route('paints.index');
    }

    public function destroy(Paint $object)
    {
        $object->delete();
        return redirect()->route('paints.index');
    }
}
