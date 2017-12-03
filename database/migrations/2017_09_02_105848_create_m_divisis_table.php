<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMDivisisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_divisis', function (Blueprint $table) {
            $table->increments('id');
            $table->string('division_name',100)->unique();
            $table->integer('parent')->unsigned()->nullable();
            // foreign ke master direksi
            //$table->integer('direktorat_id')->unsigned()->nullable();
            $table->integer('kadiv_id')->unsigned()->nullable(); 
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('direktorat_id') ->references('id')->on('m_direktorats')
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
        Schema::dropIfExists('m_divisis');
    }
}
