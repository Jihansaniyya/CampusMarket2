<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'store_name'      => 'required|string|max:255',
            'description'     => 'nullable|string|max:1000',
            'pic_name'        => 'required|string|max:255',
            'pic_phone'       => 'required|string|max:30',
            'pic_email'       => 'required|email|max:255|unique:users,email',
            'pic_address'     => 'required|string|max:500',
            'rt'              => 'nullable|string|max:10',
            'rw'              => 'nullable|string|max:10',
            'kelurahan'       => 'nullable|string|max:255',
            'kabupaten'       => 'nullable|string|max:255',
            'provinsi'        => 'nullable|string|max:255',
            'ktp_number'      => 'nullable|string|max:100',
            'password'        => 'required|string|min:6|confirmed',
            'photo_pic'       => 'nullable|image|max:2048',
            'ktp_file'        => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:4096',
        ]);

        // handle uploads
        if ($request->hasFile('photo_pic')) {
            $data['photo_pic'] = $request->file('photo_pic')->store('uploads/pics', 'public');
        }
        if ($request->hasFile('ktp_file')) {
            $data['ktp_file'] = $request->file('ktp_file')->store('uploads/ktp', 'public');
        }

        // create user (seller). Pastikan kolom di users table ada sesuai array di bawah atau sesuaikan model/migration.
        $user = User::create([
            'name'        => $data['pic_name'],
            'email'       => $data['pic_email'],
            'password'    => Hash::make($data['password']),
            'store_name'  => $data['store_name'] ?? null,
            'description' => $data['description'] ?? null,
            'pic_phone'   => $data['pic_phone'] ?? null,
            'pic_address' => $data['pic_address'] ?? null,
            'rt'          => $data['rt'] ?? null,
            'rw'          => $data['rw'] ?? null,
            'kelurahan'   => $data['kelurahan'] ?? null,
            'kabupaten'   => $data['kabupaten'] ?? null,
            'provinsi'    => $data['provinsi'] ?? null,
            'ktp_number'  => $data['ktp_number'] ?? null,
            'photo_pic'   => $data['photo_pic'] ?? null,
            'ktp_file'    => $data['ktp_file'] ?? null,
            'role'        => 'seller',
        ]);

        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Registrasi berhasil. Selamat datang!');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors(['email' => 'Email atau password salah'])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}

