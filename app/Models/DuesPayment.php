<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DuesPayment extends Model { 
    protected $fillable=['member_id','period','amount','paid_at','method','reference'];
     public function member(): BelongsTo {
         return $this->belongsTo(Member::class);
        } }
