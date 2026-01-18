<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'equipment_id',
        'rental_date',
        'return_date',
        'total_days',
        'total_price',
        'status',
    ];

    protected $casts = [
        'rental_date' => 'date',
        'return_date' => 'date',
        'total_price' => 'decimal:2',
    ];

    const STATUS_PENDING   = 'pending';
    const STATUS_ACTIVE    = 'active';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_REJECTED  = 'rejected';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'pending' => 'warning',
            'active' => 'success',
            'completed' => 'info',
            'cancelled' => 'secondary',
            default => 'dark',
        };
    }

    public function getStatusTextAttribute()
    {
        return match($this->status) {
            'pending' => 'Menunggu',
            'active' => 'Aktif',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            default => ucfirst($this->status),
        };
    }

    public function canBeCancelled()
    {
        return $this->status === 'pending';
    }

    public function getStatusIconAttribute()
    {
        return match($this->status) {
            'pending' => 'clock',
            'active' => 'play',
            'completed' => 'check-circle',
            'cancelled' => 'times-circle',
            default => 'question-circle',
        };
    }

}
