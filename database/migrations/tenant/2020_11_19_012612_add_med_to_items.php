<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMedToItems extends Migration
{
  /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->unsignedInteger('laboratorio_id')->nullable()->after('category_id');
            $table->foreign('laboratorio_id')->references('id')->on('laboratorios');

            $table->unsignedInteger('presentacion_id')->nullable()->after('laboratorio_id');
            $table->foreign('presentacion_id')->references('id')->on('presentaciones');

            $table->string('tipprodmed_id')->nullable()->after('presentacion_id');
            $table->foreign('tipprodmed_id')->references('id')->on('cat_tipprodmed');

            $table->string('clasemed_id')->nullable()->after('tipprodmed_id');
            $table->foreign('clasemed_id')->references('id')->on('cat_clasemed');

            $table->string('concentracion')->nullable()->after('clasemed_id');
            $table->string('via')->nullable()->after('concentracion');
            $table->string('contraindicaciones')->nullable()->after('via');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropForeign(['laboratorio_id']);
            $table->dropColumn('laboratorio_id');

            $table->dropForeign(['presentacion_id']);
            $table->dropColumn('presentacion_id');

            $table->dropForeign(['tipprodmed_id']);
            $table->dropColumn('tipprodmed_id');

            $table->dropForeign(['clasemed_id']);
            $table->dropColumn('clasemed_id');

            $table->dropColumn('concentracion')->after('clasemed_id');
            $table->dropColumn('via')->after('concentracion');
            $table->dropColumn('contraindicaciones')->after('via');
        });
    }
}
