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
        Schema::create('TbRule', function (Blueprint $table) {
            $table->id('id_rule');
            $table->json('item_ante');
            $table->json('item_cons');
            $table->json('nilai_supp');
            $table->json('nilai_conf');
            $table->json('nilai_lift');
        });
        // Schema::create('TbRule', function (Blueprint $table) {
        //     $table->id('id_rule');
        //     $table->string('item_ante');
        //     $table->string('item_cons');
        //     $table->double('nilai_supp');
        //     $table->double('nilai_conf');
        //     $table->double('nilai_lift');
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('TbRule');
    }
};