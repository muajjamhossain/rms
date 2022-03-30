<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockCatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_cats', function (Blueprint $table) {
            $table->bigIncrements('CateId');
            $table->string('CateName')->unique();
            $table->boolean('CateStatus')->default(true);
           $table->timestamps();
        });

        DB::table('stock_cats')->insert([
            'CateName' => 'Hot' 
        ]);
        DB::table('stock_cats')->insert([
            'CateName' => 'Cool' 
        ]);
        DB::table('stock_cats')->insert([
            'CateName' => 'Fry' 
        ]);


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_cats');
    }
}
