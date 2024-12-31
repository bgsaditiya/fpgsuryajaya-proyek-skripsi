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
        Schema::create('TbKonfigurasi', function (Blueprint $table) {
            $table->id('id_konf');
            $table->integer('jum_data');
            $table->integer('max_rule');
            $table->date('tgl_awal');
            $table->date('tgl_akhir');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbkonfigurasi');
    }
};