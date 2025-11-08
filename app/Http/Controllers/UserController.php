<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class UserController extends Controller
{
    public function index()
    {
        //$roles = Role::all();
        $roles = [
            ['id' => 1, 'name' => 'Admin'],
            ['id' => 2, 'name' => 'Operador'],
        ];

        return view('user.index', ['roles' => $roles]);
    }

    public function list(Request $request): JsonResponse
    {
        $users = User::all();

        return response()->json(['users' => $users]);
    }

    public function add(Request $request): JsonResponse
    {
        $rows = DB::table('users')->where('email', $request->email)->count();
        if($rows > 0 ) {
            return response()->json(['status'=>'error', 'message'=>'Ya existe un usuario con el mismo correo']);
        }else{
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role = $request->roleId;
            $user->save();

            return response()->json(['status'=>'success', 'message'=>'El usuario fue agregado']);
        }
    }

    public function edit(Request $request): JsonResponse
    {
        $user = User::find($request->userId);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = $request->roleId;
        $user->update();

        return response()->json(['status'=>'success', 'message'=>'El usuario fue actualizado']);
    }

    public function remove(Request $request): JsonResponse
    {
        $rows = DB::table('movies')->where('userId', $request->userId)->count();
        if($rows > 0 ) {
            return response()->json(['status'=>'error', 'message'=>'No se puede eliminar usuarios con peliculas relacionadas']);
        }else{
            User::find($request->userId)->delete();
            return response()->json(['status'=>'success', 'message'=>'El Usuario fue eliminado']);
        }
    }
}
