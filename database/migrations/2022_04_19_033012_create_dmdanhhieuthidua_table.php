<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDmdanhhieuthiduaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dmdanhhieuthidua', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('stt')->default(1);
            $table->string('madanhhieutd')->unique();
            $table->string('tendanhhieutd')->nullable();
            $table->string('phanloai')->nullable();
            $table->string('ghichu')->nullable();
            $table->string('ttnguoitao')->nullable();
            $table->string('phamviapdung')->nullable();
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
        Schema::dropIfExists('dmdanhhieuthidua');
    }
}
