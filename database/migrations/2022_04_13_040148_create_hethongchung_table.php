<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHethongchungTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hethongchung', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('phanloai')->nullable();
            $table->string('tendonvi')->nullable();
            $table->string('maqhns')->nullable();
            $table->string('diachi')->nullable();
            $table->string('dienthoai')->nullable();
            $table->string('thutruong')->nullable();
            $table->string('ketoan')->nullable();
            $table->string('nguoilapbieu')->nullable();
            $table->string('diadanh')->nullable();
            $table->text('thietlap')->nullable();
            $table->text('thongtinhd')->nullable();
            $table->string('emailql')->nullable();
            $table->string('tendvhienthi')->nullable();
            $table->string('tendvcqhienthi')->nullable();
            $table->string('ipf1')->nullable();
            $table->string('ipf2')->nullable();
            $table->string('ipf3')->nullable();
            $table->string('ipf4')->nullable();
            $table->string('ipf5')->nullable();
            $table->integer('solandn')->default(6);
            //thông tin Form giới thiệu
            $table->string('tencongty')->nullable();
            $table->string('sodienthoaicongty')->nullable();
            $table->string('diachicongty')->nullable();
            $table->string('logocongty')->nullable();
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
        Schema::dropIfExists('hethongchung');
    }
}
