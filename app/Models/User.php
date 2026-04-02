<?php

namespace App\Models;

use App\Notifications\CustomVerifyEmail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address',
        'store_name',
        'store_description',
        'pic_name',
        'pic_phone',
        'pic_email',
        'pic_address',
        'rt',
        'rw',
        'kelurahan',
        'kota_kab',
        'provinsi',
        'no_ktp',
        'file_ktp',
        'avatar',
        'approval_status',
        'approved_at',
        'rejection_reason',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'approved_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Send the email verification notification (CUSTOM).
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new CustomVerifyEmail);
    }

    /**
     * Products that belong to the seller.
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'seller_id');
    }

    public function getKtpUrlAttribute(): ?string
    {
        return $this->resolveMediaUrl($this->file_ktp, ['ktp']);
    }

    public function getAvatarUrlAttribute(): ?string
    {
        return $this->resolveMediaUrl($this->avatar, ['foto_pic', 'avatar']);
    }

    private function resolveMediaUrl(?string $path, array $fallbackDirs = []): ?string
    {
        if (!$path) {
            return null;
        }

        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        $normalizedPath = ltrim($path, '/');

        if (str_starts_with($normalizedPath, 'storage/')) {
            $normalizedPath = substr($normalizedPath, 8);
        }

        if (str_starts_with($normalizedPath, 'public/')) {
            $normalizedPath = substr($normalizedPath, 7);
        }

        if (Storage::disk('public')->exists($normalizedPath)) {
            return Storage::disk('public')->url($normalizedPath);
        }

        $fileName = basename($normalizedPath);

        foreach ($fallbackDirs as $dir) {
            $candidatePath = trim($dir, '/') . '/' . $fileName;

            if (Storage::disk('public')->exists($candidatePath)) {
                return Storage::disk('public')->url($candidatePath);
            }
        }

        return null;
    }
}
