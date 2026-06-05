<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

it('allows valid user login', function () {

    $user = User::create([
        'name' => 'Buyer Test',
        'email' => 'buyer@example.com',
        'password' => Hash::make('password123'),
        'email_verified_at' => now(),
        'role' => 'buyer'
    ]);

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password123'
    ]);

    $response->assertRedirect();
});