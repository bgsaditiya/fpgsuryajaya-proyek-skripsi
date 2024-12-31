<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        // Schema::create('TbArsip', function (Blueprint $table){
        //     $table->id('id_arsip');
        // });
        // Schema::table('TbArsip', function ($table){
        //     $table->dropPrimary('TbArsip_id_arsip_primary');
        // });
        // Schema::table('TbArsip', function ($table){
        //     $table->increments('id_rule')->unique()->unsigned()->index()->after('id_arsip');
        //     $table->foreign('id_rule') // a column on posts table
        //         ->references('id_rule') //name of the column on users (referenced) table
        //         ->on('TbRule')    //name of the referenced table 
        //         ->onDelete('cascade'); //constrain
        // });
        // Schema::table('TbArsip', function ($table){
        //     $table->dropPrimary('TbArsip_id_rule_primary');
        // });
        // Schema::table('TbArsip', function ($table){
        //     $table->string('username')->after('id_rule');
        //     $table->foreign('username') // a column on posts table
        //         ->references('username') //name of the column on users (referenced) table
        //         ->on('TbUser')    //name of the referenced table 
        //         ->onDelete('cascade'); //constrain
        // });
        // Schema::table('TbArsip', function ($table){
        //     $table->increments('id_konf')->unique()->unsigned()->index()->after('username');
        //     $table->foreign('id_konf') // a column on posts table
        //         ->references('id_konf') //name of the column on users (referenced) table
        //         ->on('TbRule')    //name of the referenced table 
        //         ->onDelete('cascade'); //constrain
        // });
        // Schema::table('TbArsip', function ($table){
        //     $table->dropPrimary('TbArsip_id_konf_primary');
        // });
        // Schema::table('TbArsip', function ($table){
        //     $table->date('tgl_analisis')->after('id_konf');
        //     $table->primary('id_arsip');
        // });
        Schema::create('tbarsip', function (Blueprint $table) {
            $table->id('id_arsip');
            $table->foreignId('id_rule')->nullable();
            $table->string('username', 20);
            $table->foreignId('id_konf')->nullable();
            $table->date('tgl_analisis');

            $table->foreign('username') // a column on posts table
                ->references('username') //name of the column on users (referenced) table
                ->on('tbuser')    //name of the referenced table 
                ->onDelete('cascade')->onUpdate('cascade'); //constrain

            $table->foreign('id_rule') // a column on posts table
                ->references('id_rule') //name of the column on users (referenced) table
                ->on('tbrule')    //name of the referenced table 
                ->onDelete('cascade'); //constrain

            $table->foreign('id_konf') // a column on posts table
                ->references('id_konf') //name of the column on users (referenced) table
                ->on('tbkonfigurasi')    //name of the referenced table 
                ->onDelete('cascade'); //constrain
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('TbArsip');
    }
};