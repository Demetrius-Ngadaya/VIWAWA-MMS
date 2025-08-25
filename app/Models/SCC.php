<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SCC extends Model { 
    protected $fillable=['name','parish_id']; 
}
