<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDsphongtraothiduaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dsphongtraothidua', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('maphongtraotd')->unique();
            $table->string('maloaihinhkt')->nullable();
            $table->string('phanloai')->nullable();
            $table->string('soqd')->nullable(); // Số quyết định
            $table->date('ngayqd')->nullable(); // Ngày quyết định
            $table->string('noidung')->nullable();
            $table->string('khauhieu')->nullable();
            $table->string('phamviapdung')->nullable();
            $table->date('tungay')->nullable(); // Ngày bắt đầu nhận hồ sơ
            $table->date('denngay')->nullable(); // Ngày kết thúc nhận hồ sơ
            $table->string('ghichu')->nullable();
            //tài liệu đính kèm
            $table->string('totrinh')->nullable(); // Tờ trình
            $table->string('qdkt')->nullable(); // Quyết định
            $table->string('bienban')->nullable(); // Biên bản           
            $table->string('tailieukhac')->nullable(); // Tài liệu khác
            //Trạng thái đơn vị
            $table->string('madonvi')->nullable(50);
            $table->string('madonvi_nhan')->nullable(50);
            $table->string('lydo')->nullable();
            $table->string('thongtin')->nullable();//chưa dùng
            $table->string('trangthai')->nullable(20);
            $table->dateTime('thoigian')->nullable();
            //Trạng thái huyện
            $table->string('madonvi_h')->nullable(50);
            $table->string('madonvi_nhan_h')->nullable(50);
            $table->string('lydo_h')->nullable();
            $table->string('thongtin_h')->nullable();//chưa dùng
            $table->string('trangthai_h')->nullable(20);
            $table->dateTime('thoigian_h')->nullable();
            //Trạng thái tỉnh
            $table->string('madonvi_t')->nullable(50);
            $table->string('madonvi_nhan_t')->nullable(50);
            $table->string('lydo_t')->nullable();
            $table->string('thongtin_t')->nullable();//chưa dùng
            $table->string('trangthai_t')->nullable(20);
            $table->dateTime('thoigian_t')->nullable();
            //Trạng thái trung ương
            $table->string('madonvi_tw')->nullable(50);
            $table->string('madonvi_nhan_tw')->nullable(50);
            $table->string('lydo_tw')->nullable();
            $table->string('thongtin_tw')->nullable();//chưa dùng
            $table->string('trangthai_tw')->nullable(20);
            $table->dateTime('thoigian_tw')->nullable();
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
        Schema::dropIfExists('dsphongtraothidua');
    }
}
