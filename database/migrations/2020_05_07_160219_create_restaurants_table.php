<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRestaurantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('url');
            $table->integer('client_id');
            $table->string('logo')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('address')->nullable();
            $table->integer('menu_categorised')->default(1);
            $table->integer('menu_theme')->default(1);
            $table->boolean('menu_image_display')->default(1);
            $table->string('menu_heading')->default('<span>TRY OUR</span>&nbsp;DELICIOUS MENU');
            $table->boolean('takeaway_switch')->default(1);
            $table->string('currency_symbol')->default('৳');
            $table->boolean('table_option')->default(1);
            $table->boolean('status')->default(1);
            $table->boolean('trusted_manager')->default(1);
            $table->integer('invoice')->default(1);
            $table->interger('discount')->default(0);
            $table->decimal('vat',10,2)->default(0.00);
            $table->string('slug');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('restaurants');
    }
}
