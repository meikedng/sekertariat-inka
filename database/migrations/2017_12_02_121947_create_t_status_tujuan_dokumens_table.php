<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTStatusTujuanDokumensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_status_tujuan_dokumens', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tujuan_dokumen_id')->unsigned();
            $table->integer('status_tujuan_id')->unsigned();
            $table->string('keterangan')->nnullable();
            $table->date('tgl_status');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('tujuan_dokumen_id') ->references('id')->on('t_tujuan_dokumens')
                ->onUpdate('cascade')->onDelete('cascade');
            
            $table->foreign('status_tujuan_id') ->references('id')->on('m_status_tujuan_dokumens')
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
        Schema::dropIfExists('t_status_tujuan_dokumens');
    }
}
