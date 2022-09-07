<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelatedProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('related_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('child_id');


            $table->foreign('product_id')->references('id')->on('products')->cascadeOnDelete();
            $table->foreign('child_id')->references('id')->on('products')->cascadeOnDelete();
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
        Schema::table('related_products',function (Blueprint $table){
            $table->dropForeign(['product_id']);
            $table->dropForeign(['child_id']);
        });

        Schema::dropIfExists('related_products');
    }
}
