<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'room_id',
        'price',
        'check_in',
        'check_out', 
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'check_in' => 'date',
        'check_out' => 'date',
        // 'status' => BookingStatus::class, // If using enums
    ];

    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = is_string($value) 
            ? str_replace(',', '', $value) 
            : $value;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if ($model->check_in >= $model->check_out) {
                throw new \Exception('Check-out date must be after check-in date');
            }
        });
    }
}