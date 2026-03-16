<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LevelController extends Controller
{
    /**
     * Display a listing of the levels.
     */
    public function index()
    {
        $levels = Level::orderBy('order')->get();
        return view('admin.levels.index', compact('levels'));
    }

    /**
     * Show the form for creating a new level.
     */
    public function create()
    {
        return view('admin.levels.create');
    }

    /**
     * Store a newly created level in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'order'       => 'nullable|integer',
        ]);

        Level::create([
            'title'       => $request->title,
            'description' => $request->description,
            'price'       => $request->price,
            'slug'        => Str::slug($request->title), // توليد slug فريد
            'order'       => $request->order ?? 0,
            'publish'      => $request->publish ?? false,
        ]);

        return redirect()->route('admin.levels.index')->with('success', 'تم إضافة المستوى بنجاح.');
    }

    /**
     * Show the form for editing the specified level.
     */
    public function edit(Level $level)
    {
        return view('admin.levels.edit', compact('level'));
    }

    /**
     * Update the specified level in storage.
     */
    public function update(Request $request, Level $level)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'order'       => 'nullable|integer',
        ]);

        $level->update([
            'title'       => $request->title,
            'description' => $request->description,
            'price'       => $request->price,
            'slug'        => Str::slug($request->title), // تحديث slug
            'order'       => $request->order ?? $level->order,
            'publish'      => $request->publish ?? $level->publish,
        ]);

        return redirect()->route('admin.levels.index')->with('success', 'تم تحديث المستوى بنجاح.');
    }

    /**
     * Remove the specified level from storage.
     */
    public function destroy(Level $level)
    {
        // حذف جميع الفيديوهات المرتبطة أولاً (أو استخدام onDelete cascade)
        $level->videos()->delete();
        $level->delete();

        return redirect()->route('admin.levels.index')->with('success', 'تم حذف المستوى.');
    }
}
