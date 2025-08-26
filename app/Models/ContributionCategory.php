<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ContributionCategory extends Model
{
    protected $fillable = [
        'name',
        'contribution_amount',
        'description',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'contribution_amount' => 'decimal:2'
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function contributions(): HasMany
    {
        return $this->hasMany(Contribution::class);
    }
}