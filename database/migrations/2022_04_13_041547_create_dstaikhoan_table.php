<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDstaikhoanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dstaikhoan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tentaikhoan')->nullable();
            $table->string('tendangnhap')->unique();
            $table->string('matkhau')->nullable();
            $table->string('madonvi')->nullable();
            $table->string('email')->nullable();
            $table->string('sodienthoai')->nullable();
            $table->integer('trangthai')->default(0);
            $table->string('sadmin')->nullable();
            $table->string('ttnguoitao')->nullable();
            $table->text('lydo')->nullable();
            $table->integer('solandn')->default(1);
            //chia nhóm chức năng
            $table->boolean('nhaplieu')->default(0);
            $table->boolean('tonghop')->default(0);
            $table->boolean('hethong')->default(0);
            $table->boolean('chucnangkhac')->default(0);
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
        Schema::dropIfExists('dstaikhoan');
    }
}
