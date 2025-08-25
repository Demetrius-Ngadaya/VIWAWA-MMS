<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration { 
    public function up(){
         Schema::create('dues_payments', function(Blueprint $t){ $t->id();
             $t->foreignId('member_id')->constrained()->cascadeOnDelete(); 
             $t->string('period'); // YYYY-MM
 $t->decimal('amount',12,2);
  $t->date('paid_at'); 
  $t->string('method')->nullable(); 
  $t->string('reference')->nullable(); 
  $t->timestamps(); 
}); 
} public function down(){ Schema::dropIfExists('dues_payments'); 
}
 };
