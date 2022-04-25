<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDshosotdktcumkhoiTieuchuanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dshosotdktcumkhoi_tieuchuan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('stt')->default(1);
            $table->string('mahosotdkt')->nullable();// ký hiệu
            $table->string('madoituong')->nullable();
            $table->string('matapthe')->nullable();
            $table->string('madanhhieutd')->nullable();
            $table->string('matieuchuandhtd')->nullable();
            $table->boolean('dieukien')->default(0);
            $table->string('mota')->nullable();
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
        Schema::dropIfExists('dshosotdktcumkhoi_tieuchuan');
    }
}
