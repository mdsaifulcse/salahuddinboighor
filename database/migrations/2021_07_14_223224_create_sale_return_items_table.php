<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleReturnItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_return_items', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('sale_return_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('order_item_qty')->comment('item purchase Qty');
            $table->integer('return_item_qty');
            $table->integer('sale_price')->comment('Purchase price');
            $table->integer('item_total_price');
            $table->integer('item_return_price');

            $table->softDeletes();
            $table->foreign('sale_return_id')->references('id')->on('sale_returns')->cascadeOnDelete();
            $table->foreign('product_id')->references('id')->on('products')->cascadeOnDelete();

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
        Schema::table('sale_return_items',function (Blueprint $table){
            $table->dropForeign(['sale_return_id']);
            $table->dropForeign(['product_id']);
        });

        Schema::dropIfExists('sale_return_items');
    }
}
