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
            // Data Akun
            'name'                => 'required|string|max:255',
            'email'               => 'required|email|max:255|unique:users,email',
            'phone'               => 'required|string|max:20',
            'password'            => 'required|string|min:8|confirmed',
            'role'                => 'nullable|in:seller', // Form ini khusus seller only
            'terms'               => 'required|accepted',
            
            // Data Toko (required karena ini form seller)
            'store_name'          => 'required|string|max:255',
            'store_description'   => 'required|string|max:1000',
            
            // Data PIC (required)
            'pic_name'            => 'required|string|max:255',
            'pic_phone'           => 'required|string|max:20',
            'pic_email'           => 'required|email|max:255',
            'pic_address'         => 'required|string|max:500',
            
            // Alamat PIC (required)
            'rt'                  => 'required|string|max:10',
            'rw'                  => 'required|string|max:10',
            'kelurahan'           => 'required|string|max:255',
            'kota_kab'            => 'required|string|max:255',
            'provinsi'            => 'required|string|max:255',
            
            // Identitas (required)
            'no_ktp'              => 'required|string|max:20',
            'file_ktp'            => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'foto_pic'            => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Handle file uploads
        if ($request->hasFile('file_ktp')) {
            $validated['file_ktp'] = $request->file('file_ktp')->store('ktp', 'public');
        }
        
        if ($request->hasFile('foto_pic')) {
            $validated['foto_pic'] = $request->file('foto_pic')->store('foto_pic', 'public');
        }

        // Create user
        $user = User::create([
            'name'                => $validated['name'],
            'email'               => $validated['email'],
            'phone'               => $validated['phone'],
            'password'            => Hash::make($validated['password']),
            'role'                => $validated['role'] ?? 'seller', // Default to seller for this form
            'store_name'          => $validated['store_name'] ?? null,
            'store_description'   => $validated['store_description'] ?? null,
            'pic_name'            => $validated['pic_name'] ?? null,
            'pic_phone'           => $validated['pic_phone'] ?? null,
            'pic_email'           => $validated['pic_email'] ?? null,
            'pic_address'         => $validated['pic_address'] ?? null,
            'rt'                  => $validated['rt'] ?? null,
            'rw'                  => $validated['rw'] ?? null,
            'kelurahan'           => $validated['kelurahan'] ?? null,
            'kota_kab'            => $validated['kota_kab'] ?? null,
            'provinsi'            => $validated['provinsi'] ?? null,
            'no_ktp'              => $validated['no_ktp'] ?? null,
            'file_ktp'            => $validated['file_ktp'] ?? null,
            'avatar'              => $validated['foto_pic'] ?? null,
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
            
            $user = Auth::user();
            
            // Check if email is verified
            if (!$user->hasVerifiedEmail()) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Email Anda belum diverifikasi. Silakan cek email untuk link verifikasi.'
                ])->onlyInput('email');
            }
            
            // Check approval status for sellers
            if ($user->role === 'seller') {
                if ($user->approval_status === 'pending') {
                    // Seller still waiting for approval
                    return redirect()->route('waiting.approval');
                } elseif ($user->approval_status === 'rejected') {
                    Auth::logout();
                    return back()->withErrors([
                        'email' => 'Pendaftaran Anda ditolak. Alasan: ' . ($user->rejection_reason ?? 'Tidak ada keterangan.')
                    ])->onlyInput('email');
                }
            }
            
            // Redirect based on role
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
        return redirect()->route('login');
    }
}

