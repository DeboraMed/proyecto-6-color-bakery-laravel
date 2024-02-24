<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Color;
use App\Models\Favorite;
use App\Models\Palette;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Crea una base de datos inicial con 256 colores
        Color::factory(100)->create();

        // Crea 10 usuarios donde cada uno tiene 5 proyectos y 10 paletas para cada uno
        User::factory(10)->has(Project::factory(5)->hasPalettes(10))
            // Ademas, estos usuarios tendran 10 favoritos cada uno
            ->has(Favorite::factory(10))
            ->create();

        $colors = Color::all();

        // Asociaremos 5 colores aleatorios a las paletas creadas
        Palette::all()->each(
            function ($palette) use ($colors) {
                $palette->colors()->attach(
                    $colors->random(5)->pluck('id')->toArray()
                );
            });

        // Y un color aleatorio a cada favorito
        Favorite::all()->each(
            function ($favorite) use ($colors) {
                $favorite->color_id = $colors->random(1)->first()->id;
                $favorite->save();
            });

        // Forzamos unas credenciales especificas para uno de los usuarios
        $first_user = User::first();
        $first_user->name = 'User Test';
        $first_user->email = 'user@test.com';
        $first_user->password = Hash::make('test_password');
        $first_user->save();
    }
}
