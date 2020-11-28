<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TenantCatalogs2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
                 /*
         ***************************************************************************************************************
         ***************************************************************************************************************
         ***************************************************************************************************************
         */
        Schema::create('cat_tipprodmed', function (Blueprint $table) {
            $table->string('id')->index();
            $table->boolean('active');
            $table->string('description');
        });

        DB::table('cat_tipprodmed')->insert([
            ['id' => '01', 'active' => true, 'description' => 'Medicamento'],
            ['id' => '02', 'active' => true, 'description' => 'Articulo'],
        ]);
                        /*
         ***************************************************************************************************************
         ***************************************************************************************************************
         ***************************************************************************************************************
         */
        Schema::create('cat_clasemed', function (Blueprint $table) {
            $table->string('id')->index();
            $table->boolean('active');
            $table->string('description');
        });

        DB::table('cat_clasemed')->insert([
            ['id' => '01', 'active' => true, 'description' => 'Comercial'],
            ['id' => '02', 'active' => true, 'description' => 'Generico'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('cat_tipprodmed');
        Schema::dropIfExists('cat_clasemed');
    }
}
