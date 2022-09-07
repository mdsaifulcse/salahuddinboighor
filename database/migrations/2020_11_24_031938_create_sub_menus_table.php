<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_menus', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('menu_id',false,20);
            $table->foreign('menu_id')->references('id')->on('menus');

            $table->string('name');
            $table->string('name_bn')->nullable();
            $table->string('url')->default('javascript:void(0)');
            $table->string('icon_class')->nullable();
            $table->string('icon')->nullable();
            $table->string('big_icon')->nullable();
            $table->tinyInteger('serial_num',false,4);

            $table->string('status')->default(\App\Models\SubMenu::ACTIVE);
            $table->string('slug')->nullable();
            $table->string('menu_for')->default(\App\Models\SubMenu::ADMIN_MENU);
            $table->string('open_new_tab')->default(\App\Models\SubMenu::NO_OPEN_NEW_TAB);

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

        Schema::table('sub_menus',function (Blueprint $table){
            $table->dropForeign(['menu_id']);
        });

        Schema::dropIfExists('sub_menus');
    }
}
