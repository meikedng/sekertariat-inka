<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMSekdirsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_sekdirs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('direksi_id')->unsigned();
            $table->integer('is_active')->default(1);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id') ->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
            
            $table->foreign('direksi_id') ->references('id')->on('m_direksis')
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
        Schema::dropIfExists('m_sekdirs');
    }
}
