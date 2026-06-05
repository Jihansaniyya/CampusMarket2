<?php

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

it('registers a seller successfully', function () {
    Storage::fake('public');

    $response = $this->post('/register', [
        'name'                  => 'Algi Seller',
        'email'                 => 'algi@example.com',
        'phone'                 => '081234567890',
        'password'              => 'password123',
        'password_confirmation' => 'password123',
        'terms'                 => '1',
        'store_name'            => 'Algi Shop',
        'store_description'     => 'Toko elektronik terlengkap',
        'pic_address'           => 'Jl. Raya No. 10',
        'rt'                    => '01',
        'rw'                    => '02',
        'kelurahan'             => 'Merdeka',
        'kota_kab'              => 'Semarang',
        'provinsi'              => 'Jawa Tengah',
        'no_ktp'                => '3301010101010001',
        'file_ktp'              => UploadedFile::fake()->create('ktp.pdf', 500),
        'foto_pic'              => UploadedFile::fake()->image('avatar.jpg'),
    ]);

    $response->assertRedirect('/email/verify');
    
    $this->assertDatabaseHas('users', [
        'email'      => 'algi@example.com',
        'store_name' => 'Algi Shop',
        'role'       => 'seller',
    ]);
});
