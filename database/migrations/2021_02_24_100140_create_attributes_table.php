<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attributes', function (Blueprint $table) {
            $table->id();

            $table->string('title',150)->nullable();
            $table->string('slug')->nullable();
            $table->string('title_title')->nullable();
            $table->tinyInteger('is_default',false,3)->default(0);
            $table->string('title_slug')->nullable();
            $table->string('color')->nullable();
            $table->string('link');
            $table->string('icon_photo')->nullable();
            $table->string('icon_class')->nullable();
            $table->integer('serial_num',false,4)->default(0);
            $table->string('status')->default(\App\Models\Attribute::ACTIVE);
            $table->softDeletes();
            $table->unsignedBigInteger('created_by', false);
            $table->unsignedBigInteger('updated_by', false)->nullable();
            $table->foreign('created_by')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('updated_by')->references('id')->on('users')->cascadeOnDelete();
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

        Schema::table('attributes',function (Blueprint $table){
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);
        });
        Schema::dropIfExists('attributes');
    }
}
