<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_invoices', function (Blueprint $table) {
            $table->id();

            $table->string('invoice_no');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('order_id')->comment('Primary Id');
            $table->unsignedBigInteger('delivery_by')->nullable();
            $table->unsignedBigInteger('shipping_id')->nullable();

            $table->float('quantity',5,1)->default(1);
            $table->float('subtotal',10,1);
            $table->integer('coupon_discount',false,8)->default(0);
            $table->integer('shipping_cost',false,8)->default(0);
            $table->float('vat_tax_percent',5,1)->default(00);
            $table->float('vat_tax_amount',5,1)->default(00);
            $table->float('total',10,1)->comment('sub_total + shipping_cos + vat_tax');
            $table->float('net_total',10,1)->comment('total - coupon_discount');
            $table->float('total_pay',10,1)->default(0);
            $table->float('tender_pay',10,1)->default(0);
            $table->float('change_amount',10,1)->default(0);

            $table->string('order_status')->default(\App\Models\Order::COMPLETE);
            $table->string('payment_status')->default(\App\Models\Order::UNPAID);
            $table->string('shipping_status')->default(\App\Models\Order::PENDING);
            $table->timestamp('delivery_date')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('payment_track')->nullable();
            $table->string('payment_gateway')->nullable();
            $table->string('payment_type')->default(\App\Models\OrderInvoice::REGULAR);

            $table->text('note')->nullable()->comment('Message by Client');
            $table->string('coupon_code')->nullable();
            $table->string('invoice_type')->default(\App\Models\OrderInvoice::ECOMMERCE);

            $table->foreign('delivery_by')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('order_id')->references('id')->on('orders')->cascadeOnDelete();
            $table->foreign('shipping_id')->references('id')->on('shipping_methods')->cascadeOnDelete();

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
        Schema::table('order_invoices',function (Blueprint $table){
            $table->dropForeign(['user_id']);
            $table->dropForeign(['order_id']);
            $table->dropForeign(['delivery_by']);
            $table->dropForeign(['shipping_id']);
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);
        });

        Schema::dropIfExists('order_invoices');
    }
}
