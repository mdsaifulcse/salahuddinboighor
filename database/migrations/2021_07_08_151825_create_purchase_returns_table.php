<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseReturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_returns', function (Blueprint $table) {
            $table->id();
            $table->string('purchase_return_no');
            $table->unsignedBigInteger('vendor_id');
            $table->unsignedBigInteger('product_purchase_id');

            $table->float('total_amount',12,2)->default(0);
            $table->float('return_amount',12,2)->default(0);
            $table->float('vendor_total_due',12,2)->default(0);
            $table->float('due_after_return',12,2)->default(0);

            $table->timestamp('return_date');
            $table->text('note')->nullable();

            $table->unsignedBigInteger('created_by', false);
            $table->unsignedBigInteger('updated_by', false)->nullable();
            $table->foreign('created_by')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('updated_by')->references('id')->on('users')->cascadeOnDelete();
            $table->softDeletes();
            $table->foreign('vendor_id')->references('id')->on('vendors')->cascadeOnDelete();
            $table->foreign('product_purchase_id')->references('id')->on('product_purchases')->cascadeOnDelete();
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
        Schema::table('purchase_returns',function (Blueprint $table){
            $table->dropForeign(['vendor_id']);
            $table->dropForeign(['product_purchase_id']);
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);
        });

        Schema::dropIfExists('purchase_returns');
    }
}
