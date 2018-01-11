<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMDireksisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_direksis', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama_direksi');
            $table->string('jabatan_direksi');
            $table->integer('id_direktorat')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_direktorat') ->references('id')->on('m_direktorats')
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
        Schema::dropIfExists('m_direksis');
    }
}
