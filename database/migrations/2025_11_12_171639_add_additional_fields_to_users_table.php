<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'seller', 'buyer'])->default('buyer')->after('password');
            $table->string('phone', 20)->nullable()->after('email');
            $table->text('address')->nullable()->after('phone');
            
            // Seller specific fields
            $table->string('store_name')->nullable()->after('address');
            $table->text('store_description')->nullable()->after('store_name');
            $table->string('pic_name')->nullable()->after('store_description');
            $table->string('pic_phone', 20)->nullable()->after('pic_name');
            $table->text('pic_address')->nullable()->after('pic_phone');
            $table->string('rt', 10)->nullable()->after('pic_address');
            $table->string('rw', 10)->nullable()->after('rt');
            $table->string('kelurahan')->nullable()->after('rw');
            $table->string('kecamatan')->nullable()->after('kelurahan');
            $table->string('kota_kab')->nullable()->after('kecamatan');
            $table->string('provinsi')->nullable()->after('kota_kab');
            $table->string('kode_pos', 10)->nullable()->after('provinsi');
            $table->string('no_ktp', 20)->nullable()->after('kode_pos');
            $table->string('file_ktp')->nullable()->after('no_ktp');
            $table->string('avatar')->nullable()->after('file_ktp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'role', 'phone', 'address', 'store_name', 'store_description',
                'pic_name', 'pic_phone', 'pic_address', 'rt', 'rw',
                'kelurahan', 'kecamatan', 'kota_kab', 'provinsi', 'kode_pos',
                'no_ktp', 'file_ktp', 'avatar'
            ]);
        });
    }
};
