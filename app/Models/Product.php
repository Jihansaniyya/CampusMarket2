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
}
