<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_users', function (Blueprint $table) {
            $table->id();
            $table->string('name',40)->default('')->comment('user nickname');
            $table->string('email',40)->default('')->unique()->comment('user email');
            $table->tinyInteger('status')->default(0)->comment('0.normal 1.forbidden');
            $table->string('password',100)->default('')->comment('user password');
            $table->string('avatar')->default('')->comment('user avatar');
            $table->comment('admin user tables');
            $table->softDeletes();
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
        Schema::dropIfExists('admin_users');
    }
};
