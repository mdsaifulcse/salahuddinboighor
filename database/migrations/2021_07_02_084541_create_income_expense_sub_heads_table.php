<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncomeExpenseSubHeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('income_expense_sub_heads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('income_expense_head_id');
            $table->string('sub_head_title');
            $table->string('link');
            $table->text('short_description')->nullable();

            $table->tinyInteger('serial_num')->default(0);
            $table->string('status')->default(\App\Models\IncomeExpenseSubHead::ACTIVE);

            $table->softDeletes();
            $table->unsignedBigInteger('created_by', false);
            $table->unsignedBigInteger('updated_by', false)->nullable();
            $table->foreign('created_by')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('updated_by')->references('id')->on('users')->cascadeOnDelete();

            $table->foreign('income_expense_head_id')->references('id')->on('income_expense_heads')->cascadeOnDelete();
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
        Schema::table('income_expense_sub_heads',function (Blueprint $table){
            $table->dropForeign(['income_expense_head_id']);
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);
        });

        Schema::dropIfExists('income_expense_sub_heads');
    }
}
