<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
     public function up(){ Schema::create('members', function(Blueprint $t){
         $t->id(); 
         $t->foreignId('user_id')->constrained()->cascadeOnDelete(); 
         $t->string('first_name'); 
         $t->string('middle_name')->nullable();
          $t->string('last_name');
           $t->enum('gender',['male','female']);
            $t->date('birthdate')->nullable(); 
            $t->enum('status',['active','inactive'])->default('active');
             $t->foreignId('diocese_id')->constrained()->cascadeOnDelete(); 
             $t->foreignId('parish_id')->constrained()->cascadeOnDelete();
              $t->foreignId('scc_id')->constrained('s_c_c_s')->cascadeOnDelete();
               $t->string('position')->nullable(); 
               $t->timestamps();
             }); 
            } public function down(){ Schema::dropIfExists('members');
             }
             };
