<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

it('rejects wrong password', function () {

    $user = User::create([
        'name' => 'Seller Test',
        'email' => 'seller@example.com',
        'password' => Hash::make('password123'),
        'email_verified_at' => now()
    ]);

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'salahpassword'
    ]);

    $response->assertSessionHasErrors('email');
});