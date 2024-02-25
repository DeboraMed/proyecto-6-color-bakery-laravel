<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $user = auth()->user();
        $projects = $user->projects()->with('palettes.colors')->get();

        return response()->json(['projects' => $projects], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        $project = auth()->user()->projects()->create([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return response()->json(['project' => $project], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $user = auth()->user();
        $user_project = $user->projects()->with('palettes.colors')->findOrFail($project->id); // Obtener el proyecto específico del usuario

        return response()->json(['project' => $user_project], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        //
        $user = auth()->user();
        $user_project = $user->projects()->findOrFail($project->id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255'
        ]);

        $user_project->update([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return response()->json(['project' => $user_project], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $user = auth()->user();
        $user_project = $user->projects()->findOrFail($project->id);

        $user_project->delete();

        return response()->json(['message' => 'Proyecto eliminado con éxito'], 200);
    }
}
