<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin Builder
 */
class Order extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi secara massal (Mass Assignment).
     */
    protected $fillable = [
        'user_id',
        'customer_name',
        'total_pages',
        'copies',
        'binding_type',
        'urgency_level',
        'estimated_duration_minutes',
        'priority_score',
        'pickup_time',
        'status',
    ];

    /**
     * Relasi ke Model User (Setiap pesanan dimiliki oleh 1 User).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}