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
        Schema::create('admin_menus', function (Blueprint $table) {
            $table->id();
            $table->integer('parent_id')->index('idx_parent_id')->default(0)->comment('parent id');
            $table->string('name',30)->default('')->comment('menu name');
            $table->string('icon')->default('')->comment('menu icon');
            $table->string('route_name')->default('')->comment('route name');
            $table->string('route_path')->default('')->comment('route path');
            $table->string('component')->default('')->comment('route component');
            $table->integer('sort')->default(0)->comment('sort value desc');
            $table->tinyInteger('hidden')->default(0)->comment('0.normal 1.hidden');
            $table->tinyInteger('type')->default(0)->comment('menus type: 0.menus 1.button(api)');
            $table->string('perm')->default('')->comment('permission label');
            $table->comment('menus table router or api tables');
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
        Schema::dropIfExists('admin_menus');
    }
};
