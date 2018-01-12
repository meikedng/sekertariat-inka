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
            // jangan dibuat unique karena aada fitur delete, means soft delete di tiap dokumen
            $table->string('nomor_referensi')->nullable();
            $table->string('nama_dokumen')->nullable();
            $table->string('perihal');
            $table->string('pengirim');
            $table->date('tgl_dok_referensi')->nullable();
            $table->string('penerima')->nullable();
            $table->date('tgl_keluar')->nullable();
            $table->date('tgl_kembali')->nullable();
            $table->integer('is_circular')->default(0);
            // $table->integer('is_closed')->default(0);
            $table->integer('is_closed')->unsigned()->default(2); // default 2 untuk dokumen proses 
            $table->integer('id_user')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('tipe_dok_id') ->references('id')->on('m_tipe_dokumens')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('is_closed') ->references('id')->on('m_status_dokumens')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_user')->references('id')->on('users')
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
