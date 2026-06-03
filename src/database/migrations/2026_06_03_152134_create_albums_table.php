<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void 
{ 
    Schema :: create ('albums' ,function (Blueprint $table ) { 
        $table->id (); 
        $table->foreignId ('artist_id'); 
        $table->string ('name' ,256);  
        $table->decimal ('streams', 15,2)->nullable (); 
        $table->integer ('year'); 
        $table->string ('image', 256)->nullable (); 
        $table->boolean ('display'); 
        $table->timestamps (); 
    }); 
} 

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('albums');
    }
};
