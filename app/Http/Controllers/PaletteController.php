<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\Palette;
use Illuminate\Http\Request;

class PaletteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $user = auth()->user();
        $projects = $user->projects()->with('palettes.colors')->get();

        // Recopilar todas las paletas de los proyectos
        $palettes = [];
        foreach ($projects as $project) {
            $palettes = array_merge($palettes, $project->palettes->toArray());
        }

        return response()->json(['palettes' => $palettes], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $project = auth()->user()->projects()->findOrFail($request->project_id);

        $request->validate([
            'name' => 'required|string|max:255',
            'project_id' => 'required|exists:projects,id',
            'colors' => 'required|array|min:1',
            'colors.*.hex' => 'required|string|max:6',
        ]);

        $palette = $project->palettes()->create([
            'name' => $request->name,
        ]);

        foreach ($request->colors as $colorData) {
            $color = Color::firstOrCreate(['hex' => $colorData['hex']]);
            $palette->colors()->attach($color->id);
        }

        return response()->json(['palette' => $palette], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Palette $palette)
    {
        //
        $user_palette = Palette::with('colors')->findOrFail($palette->id);
        auth()->user()->projects()->findOrFail($user_palette->project_id);

        return response()->json(['palette' => $user_palette], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Palette $palette)
    {
        //
        $user_palette = Palette::with('colors')->findOrFail($palette->id);
        auth()->user()->projects()->findOrFail($user_palette->project_id);

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user_palette->update([
            'name' => $request->name,
        ]);

        return response()->json(['palette' => $user_palette], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Palette $palette)
    {
        $user = auth()->user();
        $user_palette = Palette::findOrFail($palette->id);
        $user->projects()->findOrFail($user_palette->project_id);

        $user_palette->delete();

        return response()->json(['message' => 'Paleta eliminada con éxito'], 200);
    }
}
