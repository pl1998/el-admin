<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_logs', function (Blueprint $table) {
            $table->id();
            $table->string('user_name')->default('')->comment('user name');
            $table->integer('user_id')->index()->default(0)->comment('user id');
            $table->text('param')->comment('request param');
            $table->tinyInteger('method')->default(0)->comment('1.get 2.post 3.put 4.patch 5.delete');
            $table->bigInteger('ip')->default(0)->comment('ip long number');
            $table->string('path')->default('')->comment('api path');
            $table->string('ip_address')->default(0)->comment('ip address');
            $table->tinyInteger('is_danger')->default(0)->comment('danger or not request 0.no 1.yes');
            $table->json('device_info')->default('')->comment('device info');
            $table->comment('admin logs');
            $table->timestamps();
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_logs');
    }
};
