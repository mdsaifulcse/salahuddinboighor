<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBiggaponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('biggapons', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->string('target_url')->default('#');
            $table->string('status')->default(\App\Models\Biggapon::ACTIVE);
            $table->string('place')->default(\App\Models\Biggapon::TOP);
            $table->string('show_on_page')->default(\App\Models\Biggapon::HOME_PAGE);
            $table->dateTime('active_till')->nullable()->default(now()->addMonth(1));

            $table->tinyInteger('serial_num',false,4)->default(1);

            $table->unsignedBigInteger('user_id',false,20)->nullable();
            $table->foreign('user_id')->references('id')->on('users');

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

        Schema::table('biggapons',function (Blueprint $table){
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('biggapons');
    }
}
