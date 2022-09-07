<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');

            $table->string('sub_category_name',150)->nullable();
            $table->string('sub_category_name_bn',150)->nullable();
            $table->string('link');
            $table->tinyInteger('serial_num');
            $table->text('short_description')->nullable();

            $table->string('icon_photo')->nullable();
            $table->string('icon_class')->nullable();
            $table->string('status')->default(\App\Models\SubCategory::ACTIVE);

            $table->unsignedBigInteger('created_by', false);
            $table->unsignedBigInteger('updated_by', false)->nullable();
            $table->foreign('created_by')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('updated_by')->references('id')->on('users')->cascadeOnDelete();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('sub_categories',function (Blueprint $table){
            $table->dropForeign(['category_id']);
        });

        Schema::dropIfExists('sub_categories');
    }
}
