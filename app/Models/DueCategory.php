<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DueCategory extends Model
{
    protected $fillable = [
        'name',
        'due_amount',
        'description',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'due_amount' => 'decimal:2'
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function duesPayments(): HasMany
    {
        return $this->hasMany(DuesPayment::class);
    }
}