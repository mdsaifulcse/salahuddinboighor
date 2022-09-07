<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_inventories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('product_purchase_id')->nullable();
            $table->integer('new_add_qty');
            $table->integer('qty');
            $table->integer('cost_price');
            $table->integer('sale_price');

            $table->foreign('product_id')->references('id')->on('products')->cascadeOnDelete();
            //$table->foreign('product_purchase_id')->references('id')->on('product_purchases')->cascadeOnDelete();

            $table->unsignedBigInteger('created_by', false);
            $table->unsignedBigInteger('updated_by', false)->nullable();
            $table->foreign('created_by')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('updated_by')->references('id')->on('users')->cascadeOnDelete();
            $table->softDeletes();
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
        Schema::table('product_inventories',function (Blueprint $table){
            $table->dropForeign(['product_id']);
            $table->dropForeign(['product_purchase_id']);

            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);
        });

        Schema::dropIfExists('product_inventories');
    }
}
