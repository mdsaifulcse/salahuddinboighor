<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->integer('point')->default(0);
            $table->integer('discount_percent')->default(0);
            $table->string('avatar')->nullable();
            $table->string('contact')->nullable();
            $table->string('address')->nullable();
            $table->text('designation')->nullable();
            $table->text('bio')->nullable();
            $table->date('dob')->nullable();
            $table->string('nid')->nullable();
            $table->string('nid_photo')->nullable();

            $table->timestamp('joining_date')->nullable();
            $table->integer('salary',false,8)->default(0);
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
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
        Schema::table('user_profiles',function (Blueprint $table){
            $table->dropForeign(['user_id']);
        });

        Schema::dropIfExists('user_profiles');
    }
}
