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
            $table->integer('disp_user_id')->unsigned()->nullable();
            $table->longtext('keterangan');
            $table->string('penerima');
            $table->timestamps();
            $table->softDeletes();

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
