<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThicknessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('thicknesses', function (Blueprint $table) {
            $table->bigIncrements('ThicId');
            $table->string('ThicName');
            $table->boolean('ThicStatus')->default(true);
            $table->unsignedBigInteger('CateId');
            $table->unsignedBigInteger('BranId');
            $table->unsignedBigInteger('SizeId');
            $table->timestamps();

            // $table->foreign('CateId')->references('CateId')->on('stock_cats')->onDelete('cascade');
            // $table->foreign('BranId')->references('BranId')->on('brands')->onDelete('cascade');
            // $table->foreign('SizeId')->references('SizeId')->on('sizes')->onDelete('cascade');

        });


        DB::table('thicknesses')->insert([
            'ThicName' => 'Cool' ,
            'CateId' => 1,
            'BranId' => 2,
            'SizeId' => 1
        ]);
        DB::table('thicknesses')->insert([
            'ThicName' => 'Hot' ,
            'CateId' => 1,
            'BranId' => 2,
            'SizeId' => 2
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('thicknesses');
    }
}
