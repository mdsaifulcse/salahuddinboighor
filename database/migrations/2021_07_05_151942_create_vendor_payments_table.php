<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vendor_id');

            $table->string('adjust_advance')->default(\App\Models\VendorPayment::NO);
            $table->string('payment_method')->nullable();
            $table->string('payment_mobile')->nullable()->comment('if payment through mobile banking');

            $table->unsignedBigInteger('bank_account_id')->nullable()->comment('if payment trough bank');
            $table->string('check_no')->nullable()->comment('if payment trough bank');
            $table->string('payment_trxId')->nullable();

            $table->float('payable');
            $table->float('payment');
            $table->float('due')->default(0);
            $table->timestamp('payment_date');
            $table->text('note')->nullable();

            $table->string('status')->comment('Paid/Due');
            $table->softDeletes();

            $table->unsignedBigInteger('created_by', false);
            $table->unsignedBigInteger('updated_by', false)->nullable();
            $table->foreign('created_by')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('updated_by')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('vendor_id')->references('id')->on('vendors')->cascadeOnDelete();
            $table->foreign('bank_account_id')->references('id')->on('bank_accounts')->cascadeOnDelete();
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
        Schema::table('vendor_payments',function (Blueprint $table){
            $table->dropForeign(['vendor_id']);
            $table->dropForeign(['bank_account_id']);
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);
        });

        Schema::dropIfExists('vendor_payments');
    }
}
