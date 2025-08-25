<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo,HasMany};
use Illuminate\Support\Carbon;


class Member extends Model
{
protected $fillable = [
'user_id','first_name','middle_name','last_name','gender','birthdate','status',
'scc_id','parish_id','diocese_id','position'
];


protected $casts = [ 'birthdate' => 'date' ];


public function user(): BelongsTo { return $this->belongsTo(User::class); }
public function scc(): BelongsTo { return $this->belongsTo(SCC::class); }
public function parish(): BelongsTo { return $this->belongsTo(Parish::class); }
public function diocese(): BelongsTo { return $this->belongsTo(Diocese::class); }


public function duesPayments(): HasMany { return $this->hasMany(DuesPayment::class); }
public function contributions(): HasMany { return $this->hasMany(Contribution::class); }


public function getFullNameAttribute(): string { return trim($this->first_name.' '.$this->middle_name.' '.$this->last_name); }
public function getAgeAttribute(): ?int { return $this->birthdate ? $this->birthdate->age : null; }
}