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
        Schema::create('TbUser', function (Blueprint $table) {
            $table->string('username', 20)->unique()->primary_key();
            $table->string('password', 72);
            $table->string('nama', 30);
            $table->enum('jenis',['admin','pegawai']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('TbUser');
    }
};