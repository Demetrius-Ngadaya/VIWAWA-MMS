<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
     public function up(){ Schema::create('contributions', function(Blueprint $t){ $t->id(); 
        $t->foreignId('member_id')->constrained()->cascadeOnDelete(); 
        $t->foreignId('contribution_category_id')->constrained('contribution_categories')->cascadeOnDelete();
         $t->decimal('amount',12,2); $t->date('contributed_at'); 
         $t->string('reference')->nullable(); $t->text('notes')->nullable();
          $t->timestamps(); 
        }); 
    } public function down(){ Schema::dropIfExists('contributions');
     }
 };
