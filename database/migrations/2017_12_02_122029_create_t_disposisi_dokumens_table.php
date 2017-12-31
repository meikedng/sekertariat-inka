<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTDisposisiDokumensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_disposisi_dokumens', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('dest_doc_id')->unsigned();
            $table->string('disposisi_to')->nullable();
            $table->integer('disp_user_id')->unsigned()->nullable();
            $table->longtext('keterangan');
            $table->string('penerima')->string();
            // $table->integer('penerima_id')->unsigned()->nullable();
            
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('dest_doc_id') ->references('id')->on('t_tujuan_dokumens')
                ->onUpdate('cascade')->onDelete('cascade');
            
            $table->foreign('disp_user_id') ->references('id')->on('users')
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
        Schema::dropIfExists('t_disposisi_dokumens');
    }
}
