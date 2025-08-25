<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Diocese extends Model
{
    protected $fillable = ['name'];

    public function parishes()
    {
        return $this->hasMany(Parish::class);
    }
}
