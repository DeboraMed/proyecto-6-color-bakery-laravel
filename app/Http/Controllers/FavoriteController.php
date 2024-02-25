<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $user = auth()->user();
        $favorites = $user->favorites()->with('color')->get();

        return response()->json(['favorites' => $favorites], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required|string|max:255',
            'color_hex' => 'required|string|max:6',
        ]);

        $color = Color::firstOrCreate(
            ['hex' =>  request('color_hex')]
        );

        $favorite = auth()->user()->favorites()->create([
            'name' => $request->name,
            'color_id' => $color->id
        ]);

        return response()->json(['favorite' => $favorite], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Favorite $favorite)
    {
        //
        $user = auth()->user();
        $user_favorite = $user->favorites()->with('color')->findOrFail($favorite->id); // Obtener el proyecto específico del usuario

        return response()->json(['favorite' => $user_favorite], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Favorite $favorite)
    {
        //
        $user = auth()->user();
        $user_favorite = $user->favorites()->findOrFail($favorite->id);

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user_favorite->update([
            'name' => $request->name,
        ]);

        return response()->json(['favorite' => $user_favorite], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Favorite $favorite)
    {
        $user = auth()->user();
        $user_favorite = $user->favorites()->findOrFail($favorite->id);

        $user_favorite->delete();

        return response()->json(['message' => 'Favorito eliminado con éxito'], 200);
    }
}
