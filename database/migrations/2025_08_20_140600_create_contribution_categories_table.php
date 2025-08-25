<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
     public function up(){ 
        Schema::create('contribution_categories', function(Blueprint $t){ $t->id();
             $t->string('name'); 
             $t->text('description')->nullable(); 
             $t->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete(); 
             $t->timestamps(); 
            });
         } 
         public function down(){ Schema::dropIfExists('contribution_categories'); 
        }
     };
