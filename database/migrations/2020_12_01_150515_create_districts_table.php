<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDistrictsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('districts', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('division_id')->nullable();


            $table->string('district',100)->unique();
            $table->string('district_bn',100)->unique()->nullable();
            $table->string('link');
            $table->string('icon_photo')->nullable();
            $table->string('icon_class')->nullable();
            $table->string('status')->default(\App\Models\District::ACTIVE);
            $table->integer('serial_num',false,4)->nullable();
            $table->tinyInteger('show_at_home',false,1)->nullable()->default(0);

            $table->softDeletes();

            $table->foreign('division_id')->references('id')->on('divisions');
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
        Schema::table('districts',function (Blueprint $table){
            $table->dropForeign(['division_id']);
        });

        Schema::dropIfExists('districts');
    }
}
