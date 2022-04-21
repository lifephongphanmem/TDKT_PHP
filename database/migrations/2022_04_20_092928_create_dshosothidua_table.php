<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDshosothiduaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dshosothiduakhenthuong', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('mahosotdkt')->unique();    
            $table->date('ngayhoso')->nullable();   
            $table->string('noidung')->nullable();            
            $table->string('phanloai')->nullable();//hồ sơ thi đua; hồ sơ khen thưởng (để sau thống kê)
            $table->string('maloaihinhkt')->nullable();//lấy từ phong trào nếu là hồ sơ thi đua
            $table->string('maphongtraotd')->nullable();//tùy theo phân loại
            $table->string('ghichu')->nullable();
            $table->string('madonvi', 50)->nullable();
            //File đính kèm
            $table->string('baocao')->nullable();//báo cáo thành tích
            $table->string('bienban')->nullable();//biên bản cuộc họp
            $table->string('tailieukhac')->nullable();//tài liệu khác
            //Kết quả khen thưởng
            $table->string('mahosokt')->nullable();
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
        Schema::dropIfExists('dshosothiduakhenthuong');
    }
}
