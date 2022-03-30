<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sizes', function (Blueprint $table) {
            $table->bigIncrements('SizeId');
            $table->string('SizeName');
            $table->boolean('SizeStatus')->default(true);
            $table->unsignedBigInteger('CateId');
            $table->unsignedBigInteger('BranId');
            // $table->foreign('CateId')->references('CateId')->on('stock_cats')->onDelete('cascade');
            // $table->foreign('BranId')->references('BranId')->on('brands')->onDelete('cascade');
            $table->timestamps();

        });

        DB::table('sizes')->insert([
            'SizeName' => '500 GM' ,
            'CateId' => 1,
            'BranId' => 1,
        ]);

        DB::table('sizes')->insert([
            'SizeName' => '1 KG' ,
            'CateId' => 1,
            'BranId' => 2,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sizes');
    }
}
