<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackSizeUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pack_size_units', function (Blueprint $table) {
            $table->id();

            $table->string('size',150);
            $table->string('link');
            $table->text('description')->nullable();;
            $table->string('label')->default(\App\Models\PackSizeUnit::PACK_SIZE);
            $table->integer('serial_num',false,6)->default(0);
            $table->string('status')->default(\App\Models\PackSizeUnit::ACTIVE);
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
        Schema::table('pack_size_units',function (Blueprint $table){
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);
        });
        Schema::dropIfExists('pack_size_units');
    }
}
