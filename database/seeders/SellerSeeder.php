<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class SellerSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Seller Demo',
            'email' => 'sellerdemo@gmail.com',
            'password' => Hash::make('seller123'),
            'role' => 'seller',
            'phone' => '08123456789',
            'address' => 'Jl. Contoh No. 1',
            'store_name' => 'Toko Demo',
            'store_description' => 'Toko contoh untuk seller seeder.',
            'pic_name' => 'Demo PIC',
            'pic_phone' => '08129876543',
            'pic_email' => 'picdemo@gmail.com',
            'pic_address' => 'Jl. PIC No. 2',
            'rt' => '01',
            'rw' => '02',
            'kelurahan' => 'Kelurahan Demo',
            'kota_kab' => 'Kota Demo',
            'provinsi' => 'Provinsi Demo',
            'no_ktp' => '1234567890123456',
            'file_ktp' => 'ktp-demo.jpg',
            'avatar' => 'avatar-demo.jpg',
            'approval_status' => 'approved',
            'approved_at' => now(),
            'rejection_reason' => null,
        ]);
    }
}