<?php

namespace App\Http\Controllers;

use App\Models\Palette;
use App\Models\Project;
use Illuminate\Http\Request;

class PaletteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Verificar si el proyecto al que se quiere asociar la paleta existe y pertenece al usuario activo
        $project = $request->user()->projects()->findOrFail($request->project_id);

        $request->validate([
            'name' => 'required|string|max:255', // El nombre es requerido y debe ser una cadena de máximo 255 caracteres
        ]);

        $palette = $project->palettes()->create([
            'name' => $request->name,
        ]);

        return response()->json(['palette' => $palette], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Palette $palette)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Palette $palette)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Palette $palette)
    {
        //
    }
}
