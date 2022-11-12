<?php

namespace App\Http\Controllers;

use App\Models\DetailData10;
use App\Models\User;
use App\Models\Agama10;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class User10Controller extends Controller
{
    public function Register10(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:8',
                // 'repassword' => 'required|same:password',
                'role' => 'required|in:user,admin',
                // 'foto' => 'required|mimes:jpg,jpeg,png|max:2048'
            ]
        );

        $data = $request->all();
        $data["password"] = bcrypt($request->password);
        $data["is_aktif"] = $request["role"] == "user" ? 0 : 1;

        $user = new User();
        $user->fill($data);
        $save = $user->save();

        $detail = new DetailData10();
        $detail->id_user = $user->id;
        $detail->save();

        if ($save && $detail) {
            return redirect('/login10')->with('success', 'Register berhasil');
        } else {
            return back()->with('error', 'Register gagal');
        }
    }

    public function Login10(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required|min:8'
            ]
        );

        $isLogged = Auth::attempt($request->only('email', 'password'));

        if ($isLogged) {
            $user = Auth::user();

            if ($user->role == "user" && $user->is_aktif == 1) {
                return redirect('/profil10');
            }

            if ($user->role == "admin") {
                return redirect('/dashboard10');
            }

            if ($user->role == "user" && $user->is_aktif == 0) {
                Auth::logout();
                return back()->with('error', 'Akun anda belum di approve oleh admin');
            }
        }
    }
}
