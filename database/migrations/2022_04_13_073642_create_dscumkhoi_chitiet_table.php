<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDscumkhoiChitietTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dscumkhoi_chitiet', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('macumkhoi')->nullable();
            $table->string('madonvi')->nullable();
            $table->string('phanloai')->nullable();//Trưởng cụm, phó cụm, thành viên
            $table->string('ghichu')->nullable();
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
        Schema::dropIfExists('dscumkhoi_chitiet');
    }
}
