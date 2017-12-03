<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTDokumensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_dokumens', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tipe_dok_id')->unsigned();
            $table->date('tgl_masuk');
            $table->string('nomor_dokumen');
            $table->string('nomor_referensi')->nullable();
            $table->string('nama_dokumen');
            $table->string('perihal');
            $table->string('pengirim');
            $table->date('tgl_dok_referensi')->nullable();
            $table->string('penerima')->nullable();
            $table->date('tgl_keluar')->nullable();
            $table->date('tgl_kembali')->nullable();
            $table->integer('is_circular')->default(0);
            $table->integer('is_closed')->default(0);
            
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('tipe_dok_id') ->references('id')->on('m_tipe_dokumens')
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
        Schema::dropIfExists('t_dokumens');
    }
}
