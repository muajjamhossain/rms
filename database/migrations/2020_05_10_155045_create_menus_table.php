<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('price');
            $table->string('actual_cost');
            $table->string('rstrt_slug');
            $table->string('menu_tag');
            $table->string('size');
            $table->text('description');
            $table->integer('cate_id');
            $table->integer('addons');
            $table->integer('crust');
            // $table->integer('rstrt_id');
            $table->string('photo')->nullable();
            $table->boolean('status')->default(1);
            $table->integer('StocValue')->default(0);
            $table->boolean('stock_status')->default(0);
            $table->boolean('dining_service')->default(1);
            $table->boolean('takeaway_service')->default(1);
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
        Schema::dropIfExists('menus');
    }
}
