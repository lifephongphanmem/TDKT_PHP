<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDshosokhenthuongKhenthuongTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dshosokhenthuong_khenthuong', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('stt')->default(1);
            $table->string('mahosokt')->nullable();
            $table->string('mahosotdkt')->nullable();//lưu trữ sau cần dùng
            $table->string('madanhhieutd')->nullable();
            $table->string('noidungkhenthuong')->nullable();//cá nhân, tập thể
            $table->string('phanloai')->nullable();//cá nhân, tập thể
            $table->string('madoituong')->nullable();
            $table->string('matapthe')->nullable();
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
        Schema::dropIfExists('dshosokhenthuong_khenthuong');
    }
}
