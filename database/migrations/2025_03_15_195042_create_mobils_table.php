<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('mobils', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->integer('harga'); // Ini harus integer
            $table->integer('tahun');
            $table->string('transmisi');
            $table->string('bahan_bakar');
            $table->integer('seater');
            $table->integer('c1');
            $table->integer('c2');
            $table->integer('c3');
            $table->integer('c4');
            $table->integer('c5');
            $table->timestamps();
        });
        
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mobils');
    }
};
