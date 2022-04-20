<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDsphongtraothiduaTieuchuanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dsphongtraothidua_tieuchuan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('stt')->default(1);
            $table->string('maphongtraotd')->nullable();// ký hiệu
            $table->string('madanhhieutd')->nullable();
            $table->string('matieuchuandhtd')->nullable();
            $table->string('tentieuchuandhtd')->nullable();
            $table->string('cancu')->nullable();
            $table->string('ghichu')->nullable();
            $table->boolean('batbuoc')->default(1);
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
        Schema::dropIfExists('dsphongtraothidua_tieuchuan');
    }
}
