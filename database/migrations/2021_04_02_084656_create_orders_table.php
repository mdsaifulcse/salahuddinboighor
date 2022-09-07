<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->float('subtotal',10,2);
            $table->integer('coupon_discount',false,8)->default(0);
            $table->integer('shipping_cost',false,8)->default(0);
            $table->float('vat_tax_percent',5,2)->default(00);
            $table->float('vat_tax_amount',5,2)->default(00);
            $table->float('total',10,2)->comment('sub_total + shipping_cos + vat_tax');
            $table->float('net_total',10,2)->comment('total - coupon_discount');
            $table->float('total_pay',10,2)->default(0);
            $table->float('tender_pay',10,2)->default(0);

            $table->string('order_status')->default(\App\Models\Order::PENDING);
            $table->string('payment_status')->default(\App\Models\Order::UNPAID);
            $table->string('shipping_status')->default(\App\Models\Order::PENDING);
            $table->timestamp('delivery_date')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('payment_track')->nullable();
            $table->string('payment_gateway')->nullable();

            $table->string('payment_type')->default(\App\Models\Order::REGULAR);

            $table->text('reason')->nullable()->comment('Comment by Admin');
            $table->text('note')->nullable()->comment('Message by Client');

            $table->string('billing_name')->nullable();
            $table->string('billing_email')->nullable();
            $table->string('billing_phone')->nullable();
            $table->string('billing_city')->nullable();
            $table->string('billing_post')->nullable();
            $table->string('billing_post_code')->nullable();
            $table->string('billing_street_address')->nullable();

            $table->unsignedBigInteger('shipping_id')->nullable();
            $table->string('shipping_name')->nullable();
            $table->string('shipping_email')->nullable();
            $table->string('shipping_phone')->nullable();
            $table->string('shipping_city')->nullable();
            $table->string('shipping_post')->nullable();
            $table->string('shipping_post_code')->nullable();
            $table->string('shipping_street_address')->nullable();

            $table->string('coupon_code')->nullable();
            $table->longText('cart_items')->nullable();

            $table->softDeletes();
            $table->unsignedBigInteger('created_by', false);
            $table->unsignedBigInteger('updated_by', false)->nullable();
            $table->foreign('created_by')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('updated_by')->references('id')->on('users')->cascadeOnDelete();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('shipping_id')->references('id')->on('shipping_methods')->cascadeOnDelete();

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
        Schema::table('orders',function (Blueprint $table){
            $table->dropForeign(['user_id']);
            $table->dropForeign(['shipping_id']);
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);
        });

        Schema::dropIfExists('orders');
    }
}
