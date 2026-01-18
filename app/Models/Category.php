<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Tabel categories cuma punya created_at (dan bukan updated_at)
    public $timestamps = false;

    protected $fillable = [
        'name',
        'description',
    ];

    public function equipment()
    {
        return $this->hasMany(Equipment::class);
    }
}
