<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpendituresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenditures', function (Blueprint $table) {
            $table->id();

            $table->string('voucher_no');
            $table->unsignedBigInteger('income_expense_head_id');
            $table->unsignedBigInteger('income_expense_sub_head_id')->nullable();
            $table->unsignedBigInteger('bank_account_id')->nullable()->comment('if payment trough bank');

            $table->float('amount');
            $table->string('expense_method')->nullable();
            $table->string('expense_mobile')->nullable()->comment('if expense through mobile banking');

            $table->string('check_no')->nullable()->comment('if expense trough bank');
            $table->string('expense_trxId')->nullable();
            $table->string('docs_img')->nullable('If Expense Document Image available');


            $table->timestamp('expense_date');
            $table->text('note')->nullable();

            $table->softDeletes();
            $table->unsignedBigInteger('created_by', false);
            $table->unsignedBigInteger('updated_by', false)->nullable();
            $table->foreign('created_by')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('updated_by')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('income_expense_head_id')->references('id')->on('income_expense_heads')->cascadeOnDelete();
            $table->foreign('income_expense_sub_head_id')->references('id')->on('income_expense_sub_heads')->cascadeOnDelete();
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
        Schema::table('expenditures',function (Blueprint $table){
            $table->dropForeign(['income_expense_head_id']);
            $table->dropForeign(['income_expense_sub_head_id']);
            $table->dropForeign(['bank_account_id']);
        });

        Schema::dropIfExists('expenditures');
    }
}
