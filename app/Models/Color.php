<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Http;

class Color extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'hex'
    ];

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    public function palettes(): BelongsToMany
    {
        return $this->belongsToMany(Palette::class);
    }

    // Cada vez que creemos un nuevo color, se le asignará un nombre automaticamente.
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($color) {
            $color->name = self::nameByHex($color->hex);
        });
    }

    // Metodo que obtiene el nómbre de un color dado su código HEX
    public static function nameByHex($hex)
    {
    	// Github -> https://github.com/meodai/color-names
        $response = Http::get('https://api.color.pizza/v1/', [
            'values' => $hex,
        ]);

        if ($response->successful()) {
            $data = $response->json();
            $colorName = $data['colors'][0]['name'];

            return $colorName;
        }

        return 'Not found';
    }
}
