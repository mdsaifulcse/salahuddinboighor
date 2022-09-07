<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderAssignDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_assign_deliveries', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('order_id')->comment('Primary Id');
            $table->string('assign_no');
            $table->timestamp('target_delivery_date')->nullable();
            $table->time('target_delivery_time')->nullable();
            $table->string('delivery_status')->default(\App\Models\OrderAssignDelivery::PENDING);
            $table->string('payment_gateway')->nullable();
            $table->float('order_amount',10,1);
            $table->integer('shipping_cost',false,8)->default(0);

            $table->string('receive_from_delivery',20)
                ->default(\App\Models\OrderAssignDelivery::YES)->comment('If Payment From COD=Cash On Delivery');

            $table->text('note')->nullable();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('order_id')->references('id')->on('orders')->cascadeOnDelete();

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
        Schema::table('order_assign_deliveries',function (Blueprint $table){
            $table->dropForeign(['user_id']);
            $table->dropForeign(['order_id']);
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);
        });

        Schema::dropIfExists('order_assign_deliveries');
    }
}
