<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductPurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_purchases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vendor_id');
            $table->string('purchase_no');
            $table->string('po_ref')->nullable();
            $table->text('payment_term')->nullable();
            $table->string('payment_status')->default(\App\Models\ProductPurchase::DUE);
            $table->timestamp('purchase_date');
            $table->string('purchase_status')->default(\App\Models\ProductPurchase::PURCHASED);
            $table->timestamp('due_date')->nullable();
            $table->float('sub_total',12,2)->default(0);
            $table->float('discount',10,2)->default(0);
            $table->float('net_total',12,2)->default(0)->comment('sub_total - discount');
            $table->float('pay_amount',12,2)->default(0);
            $table->float('due_amount',12,2)->default(0);
            $table->text('note')->nullable();

            $table->foreign('vendor_id')->references('id')->on('vendors')->cascadeOnDelete();

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
        Schema::table('product_purchases',function (Blueprint $table){
            $table->dropForeign(['vendor_id']);
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);
        });

        Schema::dropIfExists('product_purchases');
    }
}
