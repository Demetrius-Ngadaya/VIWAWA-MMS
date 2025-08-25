<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contribution extends Model { 
    protected $fillable=['member_id','contribution_category_id','amount','contributed_at','reference','notes']; 
    public function member(): BelongsTo {
         return $this->belongsTo(Member::class);
        }
         public function category(): BelongsTo {
             return $this->belongsTo(ContributionCategory::class,'contribution_category_id');
             } }
