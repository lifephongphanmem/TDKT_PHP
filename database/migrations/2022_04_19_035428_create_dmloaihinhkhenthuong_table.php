<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDmloaihinhkhenthuongTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dmloaihinhkhenthuong', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('stt')->default(1);
            $table->string('maloaihinhkt')->unique();
            $table->string('tenloaihinhkt')->nullable();
            $table->string('phanloai')->nullable();
            $table->string('phamviapdung')->nullable();
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
        Schema::dropIfExists('dmloaihinhkhenthuong');
    }
}
