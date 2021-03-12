<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ItemsSold extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items_solds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('item_id', 255);
            $table->string('order_id', 255);
            $table->string('item_price', 255);
            $table->string('quantity', 255);
            // $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items_solds');
    }
}
