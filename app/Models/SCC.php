<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class SCC extends Model
{
    protected $table = 's_c_c_s';
    protected $fillable = ['name', 'parish_id'];

    public function parish()
    {
        return $this->belongsTo(Parish::class);
    }
}
