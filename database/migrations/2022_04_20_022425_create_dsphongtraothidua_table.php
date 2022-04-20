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
            $table->string('soqd')->nullable(); // Số quyết định
            $table->date('ngayqd')->nullable(); // Ngày quyết định
            $table->string('noidung')->nullable();
            $table->string('phamviapdung')->nullable();
            $table->date('tungay')->nullable(); // Ngày bắt đầu nhận hồ sơ
            $table->date('denngay')->nullable(); // Ngày kết thúc nhận hồ sơ
            $table->string('ghichu')->nullable();
            $table->string('madonvi')->nullable(); // Mã đơn vị
            //tài liệu đính kèm
            $table->string('totrinh')->nullable(); // Tờ trình
            $table->string('qdkt')->nullable(); // Quyết định
            $table->string('bienban')->nullable(); // Biên bản           
            $table->string('tailieukhac')->nullable(); // Tài liệu khác            
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
