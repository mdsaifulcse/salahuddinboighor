<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDivisionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('divisions', function (Blueprint $table) {
            $table->id();

            $table->string('division',100);
            $table->string('division_bn',100)->nullable();
            $table->string('link');
            $table->string('icon_photo')->nullable();
            $table->string('icon_class')->nullable();
            $table->integer('serial_num',false,4)->nullable();
            $table->string('status')->default(\App\Models\Division::ACTIVE);
            $table->tinyInteger('show_at_home',false,1)->nullable()->default(0);
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
        Schema::dropIfExists('divisions');
    }
}
