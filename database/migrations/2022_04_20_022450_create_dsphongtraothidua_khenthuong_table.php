<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDsphongtraothiduaKhenthuongTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dsphongtraothidua_khenthuong', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('stt')->default(1);
            $table->string('maphongtraotd')->nullable();
            $table->string('madanhhieutd')->nullable();
            $table->string('tendanhhieutd')->nullable();// tên danh hiệu thi đua
            $table->string('mahinhthuckt')->nullable();// tên hình thức thi đua
            $table->string('phanloai')->nullable();
            $table->integer('soluong')->nullable();// số lượng giải thưởng, khen thưởng
            $table->double('sotien')->nullable();// số tiền (tương đương )
            $table->string('ghichu')->nullable();//           
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
        Schema::dropIfExists('dsphongtraothidua_khenthuong');
    }
}
