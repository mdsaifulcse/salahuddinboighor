<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->string('big');
            $table->string('medium')->nullable();
            $table->string('small')->nullable();
            $table->string('is_thumbnail')->default(\App\Models\ProductImage::NO);


            $table->foreign('product_id')->references('id')->on('products')->cascadeOnDelete();
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
        Schema::table('product_images',function (Blueprint $table){
            $table->dropForeign(['product_id']);
        });

        Schema::dropIfExists('product_images');
    }
}
