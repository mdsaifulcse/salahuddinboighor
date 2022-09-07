<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseReturnItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_return_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('purchase_return_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('invoice_item_qty')->comment('item purchase Qty');
            $table->integer('balance_item_qty')->comment('Total stock qty');
            $table->integer('return_item_qty');
            $table->integer('cost_price')->comment('Purchase price');
            $table->integer('item_total_price');
            $table->integer('item_return_price');

            $table->softDeletes();
            $table->foreign('purchase_return_id')->references('id')->on('purchase_returns')->cascadeOnDelete();
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
        Schema::table('purchase_return_items',function (Blueprint $table){
            $table->dropForeign(['purchase_return_id']);
            $table->dropForeign(['product_id']);
        });

        Schema::dropIfExists('purchase_return_items');
    }
}
