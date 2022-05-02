<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDshosodangkyphongtraothiduaChitietTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dshosodangkyphongtraothidua_chitiet', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('mahosodk')->nullable();
            $table->string('madanhhieutd')->nullable();//có thể chọn nhiều
            $table->string('phanloai')->nullable();//cá nhân, tập thể
            //Thông tin cá nhân 
            $table->string('madoituong')->nullable();
            $table->string('maccvc')->nullable();
            $table->string('tendoituong')->nullable();
            $table->date('ngaysinh')->nullable();
            $table->string('gioitinh')->nullable();
            $table->string('chucvu')->nullable();
            $table->boolean('lanhdao')->nullable();
            //Thông tin tập thể
            $table->string('matapthe')->nullable();
            $table->string('tentapthe')->nullable();
            $table->string('ghichu')->nullable();//
            //Kết quả đánh giá
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
        Schema::dropIfExists('dshosodangkyphongtraothidua_chitiet');
    }
}
