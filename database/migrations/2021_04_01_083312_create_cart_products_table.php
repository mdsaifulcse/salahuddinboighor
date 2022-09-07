<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_products', function (Blueprint $table) {
            $table->id();
            $table->string('session_id',100)->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('product_id');
            $table->float('price',10,2);
            $table->integer('qty',false,8);
            $table->string('product_name');
            $table->string('product_image');
            $table->string('type','20')->default(\App\Models\CartProduct::ORDER);

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
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

        Schema::table('cart_products',function (Blueprint $table){
            $table->dropForeign(['user_id']);
            $table->dropForeign(['product_id']);
        });

        Schema::dropIfExists('cart_products');
    }
}
