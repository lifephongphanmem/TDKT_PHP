<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDmdanhhieuthiduaTieuchuanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dmdanhhieuthidua_tieuchuan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('stt')->default(1);
            $table->string('madanhhieutd')->nullable();
            $table->string('matieuchuandhtd')->unique();
            $table->string('tentieuchuandhtd')->nullable();
            $table->string('cancu')->nullable();
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
        Schema::dropIfExists('dmdanhhieuthidua_tieuchuan');
    }
}
