<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Parish extends Model
{
    protected $fillable = ['name', 'diocese_id'];

    public function diocese()
    {
        return $this->belongsTo(Diocese::class);
    }

    public function sccs()
    {
        return $this->hasMany(SCC::class);
    }
}
