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

    /*// modo depurado de login
    public function user(Request $request)
    {
        // devuelve un usuario
        $response = ["status" =>0,"msg"=>""];
        $data = json_decode(($request->getContent()));
        $user = User::where('email',$data->email)->first();

        // generar token de acceso con Sanctum

        if($user) {
            if (Hash::check($data->password, $user->password)) {
                // creando token de autenticacion de usuario, se le puede dar permisos tambien (admin...)
                $token = $user ->createToken("sample");
                $response["status"] = 1;
                $response["msg"] = $token->plainTextToken;
            } else {
                $response["msg"] = "Credenciales incorrectas";
            }
        }else {
            $response["msg"] = "Usuario no encontrado";

        }
        // los devuelve en json
        return response()->json($response);
    }*/


    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // TODO: revisar
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


}
