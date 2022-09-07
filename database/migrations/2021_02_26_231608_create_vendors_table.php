<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('mobile');
            $table->string('image')->nullable();
            $table->float('total_due',13,2)->default(0);
            $table->float('balance',13,2)->default(0)->comment('All Payment (Advance, initial, and regular payment');
            $table->string('contact_person')->nullable();
            $table->string('contact_person_mobile')->nullable();
            $table->text('office_address')->nullable();
            $table->text('warehouse_address')->nullable();
            $table->text('primary_supply_products')->nullable();
            $table->tinyInteger('serial_num')->default(0);
            $table->string('status')->default(\App\Models\Vendor::ACTIVE);
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

        Schema::table('vendors',function (Blueprint $table){
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);
        });
        Schema::dropIfExists('vendors');
    }
}
