<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductComment extends Model
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'product_id',
        'visitor_name',
        'visitor_phone',
        'visitor_email',
        'rating',
        'comment',
        'is_approved',
    ];

    /**
     * Get the product this comment belongs to.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}

