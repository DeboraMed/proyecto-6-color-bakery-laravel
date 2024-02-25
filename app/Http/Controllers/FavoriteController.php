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
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Favorite $favorite)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Favorite $favorite)
    {
        //
    }
}
