<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('dioceses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
        
        Schema::create('parishes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('diocese_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->timestamps();
        });
        
        Schema::create('s_c_c_s', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parish_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('s_c_c_s');
        Schema::dropIfExists('parishes');
        Schema::dropIfExists('dioceses');
    }
};