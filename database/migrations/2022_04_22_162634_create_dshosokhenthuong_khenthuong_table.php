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
            $table->boolean('ketqua')->default(0);//
            $table->string('mahinhthuckt')->nullable();
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
        Schema::dropIfExists('dshosokhenthuong_khenthuong');
    }
}
