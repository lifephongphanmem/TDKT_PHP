<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrangthaihosoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trangthaihoso', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('phanloai')->nullable();//Tên bảng
            $table->string('mahoso')->nullable();//Mã phong trào, Mã hồ sơ
            $table->string('madonvi')->nullable(20);
            $table->string('madonvi_nhan')->nullable(20);
            $table->string('lydo')->nullable();
            $table->string('thongtin')->nullable();
            $table->string('trangthai')->nullable(20);
            $table->dateTime('thoigian')->nullable();
            $table->string('tendangnhap')->nullable();
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
        Schema::dropIfExists('trangthaihoso');
    }
}
