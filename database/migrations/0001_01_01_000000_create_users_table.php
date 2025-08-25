<?php

 use Illuminate\Database\Schema\Blueprint; 
 use Illuminate\Support\Facades\Schema;
 use Illuminate\Database\Migrations\Migration;
return new class extends Migration { 
    public function up()
    { 
        Schema::create('users', function(Blueprint $t){ $t->id();
             $t->string('name'); $t->string('email')->unique(); 
             $t->string('password'); 
             $t->enum('role',['admin','member'])->default('admin'); 
             $t->enum('status',['active','inactive'])->default('active'); 
             $t->rememberToken(); 
             $t->timestamps();
             }); 
            } public function down(){
                 Schema::dropIfExists('users'); 
                } 
            };
