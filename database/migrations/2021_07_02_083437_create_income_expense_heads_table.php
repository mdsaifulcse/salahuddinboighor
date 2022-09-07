<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncomeExpenseHeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('income_expense_heads', function (Blueprint $table) {
            $table->id();
            $table->string('head_title');
            $table->string('head_type')->comment(\App\Models\IncomeExpenseHead::INCOME.'/'.\App\Models\IncomeExpenseHead::EXPENSE);
            $table->string('link');
            $table->text('short_description')->nullable();

            $table->tinyInteger('serial_num')->default(0);
            $table->string('status')->default(\App\Models\IncomeExpenseHead::ACTIVE);

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

        Schema::table('income_expense_heads',function (Blueprint $table){
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);
        });
        Schema::dropIfExists('income_expense_heads');
    }
}
