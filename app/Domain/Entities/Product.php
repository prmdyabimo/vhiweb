<?php

namespace App\Domain\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'vendor_id',
        'name',
        'description',
        'category',
        'price',
        'stock_quantity',
        'sku',
        'specifications',
        'is_active'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'specifications' => 'array',
        'is_active' => 'boolean'
    ];

    protected $with = ['vendor'];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function isInStock(): bool
    {
        return $this->stock_quantity > 0;
    }
}