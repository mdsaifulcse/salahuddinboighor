<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('company_title')->nullable();
            $table->string('company_slogan')->nullable();

            $table->string('logo')->nullable();
            $table->string('favicon')->nullable();
            $table->string('copyright')->nullable();

            $table->string('currency')->nullable();
            $table->string('currency_code')->nullable();

            $table->text('address1')->nullable();
            $table->text('address2')->nullable();

            $table->string('mobile_no1')->nullable();
            $table->string('mobile_no2')->nullable();

            $table->string('email1')->nullable();
            $table->string('email2')->nullable();

            $table->text('short_description')->nullable()->comment('About company');
            $table->text('description')->nullable()->comment('About company');
            $table->text('why_us')->nullable()->comment('About company');
            $table->text('meta_description')->nullable()->comment('About company');
            $table->text('map_embed')->nullable();

            $table->string('fb_client_id')->nullable();
            $table->string('fb_client_secret')->nullable();
            $table->string('fb_redirect')->nullable();

            $table->string('google_client_id')->nullable();
            $table->string('google_client_secret')->nullable();
            $table->string('google_redirect')->nullable();

            $table->string('default_lan')->default('en');

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
        Schema::dropIfExists('setting');
    }
}
