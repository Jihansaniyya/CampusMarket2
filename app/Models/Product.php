<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'category_id',
        'seller_id',
        'name',
        'slug',
        'description',
        'stock',
        'price',
        'sale_price',
        'rating',
        'rating_count',
        'is_active',
        'thumbnail',
    ];

    /**
     * Category relation.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Seller relation.
     */
    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    /**
     * Product reviews relation.
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(ProductReview::class);
    }

    /**
     * Product comments relation.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(ProductComment::class);
    }

    /**
     * Scope to filter products by store name.
     */
    public function scopeByStoreName($query, ?string $storeName)
    {
        if ($storeName) {
            return $query->whereHas('seller', function ($q) use ($storeName) {
                $q->where('store_name', 'like', '%' . $storeName . '%');
            });
        }
        return $query;
    }

    /**
     * Scope to filter products by category.
     */
    public function scopeByCategory($query, ?int $categoryId)
    {
        if ($categoryId) {
            return $query->where('category_id', $categoryId);
        }
        return $query;
    }

    /**
     * Scope to filter products by name.
     */
    public function scopeByProductName($query, ?string $productName)
    {
        if ($productName) {
            return $query->where('name', 'like', '%' . $productName . '%');
        }
        return $query;
    }

    /**
     * Scope to filter products by store province.
     */
    public function scopeByProvince($query, ?string $province)
    {
        if ($province) {
            return $query->whereHas('seller', function ($q) use ($province) {
                $q->where('provinsi', 'like', '%' . $province . '%');
            });
        }
        return $query;
    }

    /**
     * Scope to filter products by store city/district.
     */
    public function scopeByCity($query, ?string $city)
    {
        if ($city) {
            return $query->whereHas('seller', function ($q) use ($city) {
                $q->where('kota_kab', 'like', '%' . $city . '%');
            });
        }
        return $query;
    }

    /**
     * Get actual average rating from reviews.
     */
    public function getActualRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    /**
     * Get actual reviews count.
     */
    public function getActualReviewsCountAttribute()
    {
        return $this->reviews()->count();
    }
}
