<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Orders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id');
            $table->string('no_order');
            $table->string('kodekupon')->nullable();
            $table->timestamp('tgl_order');
            $table->double('jml_order');
            $table->double('totalharga');
            $table->string('opsibayar');
            $table->string('buktibayar')->nullable();
            $table->boolean('konfirmasi')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
