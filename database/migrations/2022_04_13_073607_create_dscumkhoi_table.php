<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDscumkhoiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dscumkhoi', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('macumkhoi')->unique();
            $table->string('tencumkhoi')->nullable();
            $table->date('ngaythanhlap')->nullable();
            $table->string('capdo')->nullable();
            $table->string('madonviql')->nullable();
            $table->string('ipf1')->nullable();
            $table->string('ipf2')->nullable();
            $table->string('ipf3')->nullable();
            $table->string('ipf4')->nullable();
            $table->string('ipf5')->nullable();
            $table->string('phamvi')->nullable();//Gán cán bộ quản lý để lọc nếu cần
            $table->string('ghichu')->nullable();
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
        Schema::dropIfExists('dscumkhoi');
    }
}
