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
            $table->string('pic_email')->nullable()->after('pic_phone');
            $table->text('pic_address')->nullable()->after('pic_email');
            $table->string('rt', 10)->nullable()->after('pic_address');
            $table->string('rw', 10)->nullable()->after('rt');
            $table->string('kelurahan')->nullable()->after('rw');
            $table->string('kota_kab')->nullable()->after('kelurahan');
            $table->string('provinsi')->nullable()->after('kota_kab');
            $table->string('no_ktp', 20)->nullable()->after('provinsi');
            $table->string('file_ktp')->nullable()->after('no_ktp');
            $table->string('avatar')->nullable()->after('file_ktp');
            
            // Approval status untuk seller
            $table->enum('approval_status', ['pending', 'approved', 'rejected'])->default('pending')->after('avatar');
            $table->timestamp('approved_at')->nullable()->after('approval_status');
            $table->text('rejection_reason')->nullable()->after('approved_at');
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
                'pic_name', 'pic_phone', 'pic_email', 'pic_address', 'rt', 'rw',
                'kelurahan', 'kota_kab', 'provinsi',
                'no_ktp', 'file_ktp', 'avatar',
                'approval_status', 'approved_at', 'rejection_reason'
            ]);
        });
    }
};
