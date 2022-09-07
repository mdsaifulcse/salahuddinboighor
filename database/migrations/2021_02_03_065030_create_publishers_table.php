<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePublishersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publishers', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('name_bn')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->string('photo')->nullable();
            $table->string('contact')->nullable();
            $table->text('address1')->nullable();
            $table->text('address2')->nullable();
            $table->text('bio')->nullable();
            $table->timestamp('establish')->nullable();

            $table->integer('serial_num',false,4)->default(0);
            $table->string('status')->default(\App\Models\Publisher::ACTIVE);

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
        Schema::table('publishers',function (Blueprint $table){
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);
        });
        Schema::dropIfExists('publishers');
    }
}
