<?php

namespace App\Http\Controllers;

use App\Models\Color;

class ColorController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show($hex)
    {
        return Color::nameByHex($hex);
    }

    public function random()
    {
        $color = Color::firstOrCreate(
            ['hex' => substr(fake()->hexColor(),1)]
        );

        return $color;
    }
}
