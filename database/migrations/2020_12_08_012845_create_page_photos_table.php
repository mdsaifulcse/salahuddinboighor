<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagePhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_photos', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('page_id',false,20);

            $table->string('photo');

            $table->softDeletes();

            $table->foreign('page_id')->references('id')->on('pages');
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
        Schema::table('page_photos',function (Blueprint $table){
            $table->dropForeign(['page_id']);
        });


        Schema::dropIfExists('page_photos');
    }
}
