<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contribution extends Model
{
    protected $fillable = [
        'member_id',
        'contribution_category_id',
        'paid_amount',
        'remaining_amount',
        'exceeded_amount',
        'status',
        'recorded_by',
        'created_by',
        'updated_by',
        'contributed_at',
        'reference',
        'notes'
    ];

    protected $casts = [
        'paid_amount' => 'decimal:2',
        'remaining_amount' => 'decimal:2',
        'exceeded_amount' => 'decimal:2',
        'contributed_at' => 'date'
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ContributionCategory::class, 'contribution_category_id');
    }

    public function recordedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Helper method to calculate payment status
    public function calculatePaymentStatus($paidAmount, $requiredAmount)
    {
        if ($paidAmount < $requiredAmount) {
            return [
                'status' => 'hajamaliza',
                'remaining_amount' => $requiredAmount - $paidAmount,
                'exceeded_amount' => 0
            ];
        } elseif ($paidAmount > $requiredAmount) {
            return [
                'status' => 'amemaliza',
                'remaining_amount' => 0,
                'exceeded_amount' => $paidAmount - $requiredAmount
            ];
        } else {
            return [
                'status' => 'amemaliza',
                'remaining_amount' => 0,
                'exceeded_amount' => 0
            ];
        }
    }
}