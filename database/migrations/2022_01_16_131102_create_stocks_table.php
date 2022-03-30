<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->bigIncrements('StocId');
            $table->unsignedBigInteger('CateId');
            $table->unsignedBigInteger('BranId');
            $table->unsignedBigInteger('SizeId');
            // $table->unsignedBigInteger('ThicId');
            $table->unsignedBigInteger('menu_id');
            $table->string('rstrt_slug',100);
            $table->unsignedInteger('StocValue');
            // $table->foreign('CateId')->references('CateId')->on('stock_cats')->onDelete('cascade');
            // $table->foreign('BranId')->references('BranId')->on('brands')->onDelete('cascade');
            // $table->foreign('ThicId')->references('ThicId')->on('thicknesses')->onDelete('cascade');
            // $table->foreign('SizeId')->references('SizeId')->on('sizes')->onDelete('cascade');
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
        Schema::dropIfExists('stocks');
    }
}
