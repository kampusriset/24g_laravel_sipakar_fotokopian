<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_name',
        'total_pages',
        'copies',
        'binding_type',
        'urgency_level',
        'payment_method',
        'estimated_duration_minutes',
        'priority_score',
        'status',
    ];

    /**
     * Relasi ke model User (1 Order milik 1 User)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}