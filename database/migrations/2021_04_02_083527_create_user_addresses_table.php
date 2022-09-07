<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();

            $table->string('city')->nullable();
            $table->string('post')->nullable();
            $table->string('post_code')->nullable();

            $table->text('address1')->nullable();
            $table->text('address2')->nullable();
            $table->text('map_address')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('type')->default(\App\Models\UserAddress::HOME);
            $table->string('is_default')->default(\App\Models\UserAddress::NO);

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
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

        Schema::table('user_addresses',function (Blueprint $table){
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('user_addresses');
    }
}
