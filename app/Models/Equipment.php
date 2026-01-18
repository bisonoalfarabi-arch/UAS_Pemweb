<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'category_id',
        'description',
        'price_per_day',
        'stock',
        'image',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }

    // ✅ Tambahan: biar Equipment::available() jalan
    public function scopeAvailable($query)
    {
        return $query->where('stock', '>', 0);
    }

    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price_per_day, 0, ',', '.');
    }

    public function getImageUrlAttribute()
    {
        return $this->image
            ? asset('storage/' . $this->image)
            : asset('images/default.jpg');
    }
}
