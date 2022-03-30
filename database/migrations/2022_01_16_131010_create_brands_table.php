<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->bigIncrements('BranId');
            $table->unsignedBigInteger('CateId');
            $table->string('BranName');
            $table->boolean('BranStatus')->default(true);
            // $table->foreign('CateId')->references('CateId')->on('stock_cats')->onDelete('cascade');
            $table->timestamps();
        });

        // Cement
        DB::table('brands')->insert([
            'BranName' => 'KFC' ,
            'CateId' => 1
        ]);
        DB::table('brands')->insert([
            'BranName' => 'BFC' ,
            'CateId' => 1
        ]);
        DB::table('brands')->insert([
            'BranName' => 'Bengle' ,
            'CateId' => 1
        ]);

// Rod
        DB::table('brands')->insert([
            'BranName' => 'Nanna' ,
            'CateId' => 2
        ]);
        DB::table('brands')->insert([
            'BranName' => 'Haji' ,
            'CateId' => 2
        ]);
        DB::table('brands')->insert([
            'BranName' => 'Rajvog' ,
            'CateId' => 2
        ]);

// Tin
        DB::table('brands')->insert([
            'BranName' => 'Shahi Polaw' ,
            'CateId' => 3
        ]);
        DB::table('brands')->insert([
            'BranName' => 'Dal vat' ,
            'CateId' => 3
        ]);
        DB::table('brands')->insert([
            'BranName' => 'Murgi Wala' ,
            'CateId' => 3
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('brands');
    }
}
