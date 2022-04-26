<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDshosokhenthuongChitietTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dshosokhenthuong_chitiet', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('mahosokt')->nullable();
            $table->string('mahosotdkt')->nullable();//lưu trữ sau cần dùng
            $table->boolean('ketqua')->default(0);//
            $table->string('lydo')->nullable();
            $table->string('madonvi')->nullable();//phục vụ lấy dữ liệu
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
        Schema::dropIfExists('dshosokhenthuong_chitiet');
    }
}
