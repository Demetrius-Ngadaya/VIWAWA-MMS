<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContributionCategory extends Model {
     protected $fillable=['name','description','created_by']; 
    }
