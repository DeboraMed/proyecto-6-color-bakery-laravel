<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use function Laravel\Prompts\password;

//use Illuminate\Validation\Rules;

class ApiController extends Controller
{
    public function users(Request $request)
    {   // devuelve el listado completo de usuarios
        $users = User::all();
        // los devuelve en json
        return response()->json($users);
    }

    /*
    public function getuser(Request $request)
    {   // devuelve el listado completo de usuarios
        $user = User::whereEmail($request->email);
        //$user = User::where(['email' => $request->email])->get()->first;
        $user
        // los devuelve en json
        return response()->json($user);
    }
*/

    public function validateUser(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Autenticación exitosa, redirige donde necesites.
            return response()->json(Auth::user());
        }
        else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function registry(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:' . User::class,
            //'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json($user);
    }



    public function login(Request $request)
    {

    }
}
