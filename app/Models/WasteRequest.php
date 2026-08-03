<?php

namespace App\Models;

use Database\Factories\WasteRequestFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class WasteRequest extends Model
{
    /** @use HasFactory<WasteRequestFactory> */
    use HasFactory;

    public const TYPES = ['Plastic', 'Paper', 'Glass', 'Metal', 'E-waste', 'Organic'];

    public const STATUSES = ['Pending', 'Accepted', 'Collected', 'Cancelled'];

    protected $fillable = [
        'user_id',
        'collector_id',
        'type',
        'weight',
        'address',
        'description',
        'image',
        'status',
        'accepted_at',
        'collected_at',
    ];

    protected function casts(): array
    {
        return [
            'weight' => 'decimal:2',
            'accepted_at' => 'datetime',
            'collected_at' => 'datetime',
        ];
    }

    public function citizen(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function collector(): BelongsTo
    {
        return $this->belongsTo(User::class, 'collector_id');
    }

    public function scopeOfType(Builder $query, ?string $type): Builder
    {
        return $type ? $query->where('type', $type) : $query;
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'Pending');
    }

    public function statusBadgeColor(): string
    {
        return match ($this->status) {
            'Pending' => 'bg-yellow-100 text-yellow-800',
            'Accepted' => 'bg-blue-100 text-blue-800',
            'Collected' => 'bg-green-100 text-green-800',
            'Cancelled' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }
}
