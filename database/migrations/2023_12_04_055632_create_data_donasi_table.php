<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataDonasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_donasi', function (Blueprint $table) {
            $table->bigIncrements('id_data_donasi');
            $table->string('judul_donasi');
            $table->longText('deskripsi_donasi');
            $table->bigInteger('target');
            $table->string('gambar_donasi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_donasi');
    }
}
