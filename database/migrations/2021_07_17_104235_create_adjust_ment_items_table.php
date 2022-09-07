<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdjustMentItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adjust_ment_items', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('adjust_ment_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('qty');
            $table->integer('price')->comment('Purchase price');

            $table->softDeletes();
            $table->foreign('adjust_ment_id')->references('id')->on('adjust_ments')->cascadeOnDelete();
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
        Schema::table('adjust_ment_items',function (Blueprint $table){
            $table->dropForeign(['adjust_ment_id']);
            $table->dropForeign(['product_id']);
        });

        Schema::dropIfExists('adjust_ment_items');
    }
}
