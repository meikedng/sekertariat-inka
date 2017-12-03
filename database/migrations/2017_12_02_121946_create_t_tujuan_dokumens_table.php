<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTTujuanDokumensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_tujuan_dokumens', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('dokumen_id')->unsigned();
            $table->integer('urutan_ke')->unsigned();
            $table->integer('dest_direksi_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('dokumen_id') ->references('id')->on('t_dokumens')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('dest_direksi_id') ->references('id')->on('m_direksis')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_tujuan_dokumens');
    }
}
