<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOurClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('our_clients', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('title');
            $table->string('logo');
            $table->string('url');
            $table->tinyInteger('serial_num',false,3);
            $table->string('status')->default(\App\Models\OurClient::ACTIVE);

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
        Schema::dropIfExists('our_clients');
    }
}
