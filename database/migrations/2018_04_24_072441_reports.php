<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Reports extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id');
            $table->date('report_starts');
            $table->date('report_ends');
            $table->string('campaignname')->nullable();
            $table->string('delivery')->nullable();
            $table->bigInteger('results')->nullable();
            $table->string('result_ind')->nullable();
            $table->bigInteger('reach')->nullable();
            $table->bigInteger('impressions')->nullable();
            $table->double('cost')->nullable();
            $table->bigInteger('amountspent')->nullable();
            $table->string('ends')->nullable();
            $table->bigInteger('pta')->nullable();
            $table->integer('agencyfee');
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
    }
}
