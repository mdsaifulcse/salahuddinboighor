<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_reviews', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('user_id');

            $table->text('content')->nullable();
            $table->tinyInteger('rating',false,3)->default(0);
            $table->integer('serial_num',false,5)->default(0);
            $table->string('status')->default(\App\Models\ProductReview::UNPUBLISH);

            $table->softDeletes();

            $table->foreign('product_id')->references('id')->on('products')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
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
        Schema::table('product_reviews',function (Blueprint $table){
            $table->dropForeign(['product_id']);
            $table->dropForeign(['user_id']);
        });

        Schema::dropIfExists('product_reviews');
    }
}
