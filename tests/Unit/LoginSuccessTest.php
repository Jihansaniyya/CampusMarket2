<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

it('allows valid user login', function () {

    $user = User::create([
        'name' => 'Seller Test',
        'email' => 'seller@example.com',
        'password' => Hash::make('password123'),
        'email_verified_at' => now(),
        'role' => 'seller'
    ]);

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password123'
    ]);

    $response->assertRedirect();
});