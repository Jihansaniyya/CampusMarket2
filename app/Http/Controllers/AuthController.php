<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'                => 'required|string|max:255',
            'email'               => 'required|email|max:255|unique:users,email',
            'phone'               => 'required|string|max:20',
            'password'            => 'required|string|min:8|confirmed',
            'role'                => 'required|in:buyer,seller',
            'terms'               => 'required|accepted',
            
            // Seller specific fields (conditional validation)
            'store_name'          => 'required_if:role,seller|nullable|string|max:255',
            'store_description'   => 'nullable|string|max:1000',
            'pic_name'            => 'nullable|string|max:255',
            'pic_phone'           => 'nullable|string|max:20',
            'pic_address'         => 'nullable|string|max:500',
            'rt'                  => 'nullable|string|max:10',
            'rw'                  => 'nullable|string|max:10',
            'kelurahan'           => 'nullable|string|max:255',
            'kecamatan'           => 'nullable|string|max:255',
            'kota_kab'            => 'nullable|string|max:255',
            'provinsi'            => 'nullable|string|max:255',
            'kode_pos'            => 'nullable|string|max:10',
            'no_ktp'              => 'nullable|string|max:20',
            'file_ktp'            => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Handle file upload
        if ($request->hasFile('file_ktp')) {
            $validated['file_ktp'] = $request->file('file_ktp')->store('ktp', 'public');
        }

        // Create user
        $user = User::create([
            'name'                => $validated['name'],
            'email'               => $validated['email'],
            'phone'               => $validated['phone'],
            'password'            => Hash::make($validated['password']),
            'role'                => $validated['role'],
            'store_name'          => $validated['store_name'] ?? null,
            'store_description'   => $validated['store_description'] ?? null,
            'pic_name'            => $validated['pic_name'] ?? null,
            'pic_phone'           => $validated['pic_phone'] ?? null,
            'pic_address'         => $validated['pic_address'] ?? null,
            'rt'                  => $validated['rt'] ?? null,
            'rw'                  => $validated['rw'] ?? null,
            'kelurahan'           => $validated['kelurahan'] ?? null,
            'kecamatan'           => $validated['kecamatan'] ?? null,
            'kota_kab'            => $validated['kota_kab'] ?? null,
            'provinsi'            => $validated['provinsi'] ?? null,
            'kode_pos'            => $validated['kode_pos'] ?? null,
            'no_ktp'              => $validated['no_ktp'] ?? null,
            'file_ktp'            => $validated['file_ktp'] ?? null,
        ]);

        // Trigger the Registered event (this will send verification email)
        event(new Registered($user));

        // Login user
        Auth::login($user);

        // Redirect to email verification notice
        return redirect()->route('verification.notice')
            ->with('success', 'Registrasi berhasil! Silakan cek email Anda untuk verifikasi akun.');
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
            
            // Check if email is verified
            if (!Auth::user()->hasVerifiedEmail()) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Email Anda belum diverifikasi. Silakan cek email untuk link verifikasi.'
                ])->onlyInput('email');
            }
            
            // Redirect based on role
            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role === 'seller') {
                return redirect()->route('seller.dashboard');
            } else {
                return redirect()->route('buyer.dashboard');
            }
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

