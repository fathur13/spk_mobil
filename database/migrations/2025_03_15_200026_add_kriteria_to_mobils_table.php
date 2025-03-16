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
        Schema::table('mobils', function (Blueprint $table) {
            $table->integer('c1'); // Harga (Cost)
            $table->integer('c2'); // Tahun (Benefit)
            $table->integer('c3'); // Transmisi (Benefit)
            $table->integer('c4'); // Bahan Bakar (Benefit)
            $table->integer('c5'); // Seater (Benefit)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('mobils', function (Blueprint $table) {
            $table->dropColumn(['c1', 'c2', 'c3', 'c4', 'c5']);
        });
    }
};
