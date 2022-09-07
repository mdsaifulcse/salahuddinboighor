<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('name_bn')->nullable();
            $table->string('isbn')->nullable();
            $table->string('edition')->nullable();
            $table->string('number_of_page')->nullable();

            $table->string('topic')->nullable();
            $table->string('keyword')->nullable();
            $table->string('link');
            $table->string('sku')->nullable();
            $table->string('barcode')->nullable();
            $table->string('qrcode')->nullable();

            $table->string('company')->nullable();
            $table->text('short_description')->nullable();
            $table->text('description')->nullable();
            $table->text('specification')->nullable();
            $table->string('installation_gide')->nullable();
            $table->string('video_url')->nullable();

            $table->integer('serial_num',false,6)->default(0);
            $table->string('status')->default(\App\Models\Product::DRAFT);
            $table->string('is_feature')->default(\App\Models\Product::NO);
            $table->string('is_new')->default(\App\Models\Product::NO);
            $table->string('added_reading_list')->default(\App\Models\Product::NO);
            $table->string('is_most_popular')->default(\App\Models\Product::NO);
            $table->string('is_top_rated')->default(\App\Models\Product::NO);
            $table->string('show_home')->default(\App\Models\Product::NO);

            $table->foreignId('publisher_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('language_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('country_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');

            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('subcategory_id')->nullable();
            $table->unsignedBigInteger('third_category_id')->nullable();
            $table->unsignedBigInteger('fourth_category_id')->nullable();
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->unsignedBigInteger('vat_tax_id')->nullable();
            $table->unsignedBigInteger('weight_unit_id')->nullable();
            $table->integer('weight',false,6)->default(0);


            $table->unsignedBigInteger('pack_size_unit_id')->nullable();
            $table->unsignedBigInteger('origin_id')->nullable();
            $table->unsignedBigInteger('length_unit_id')->nullable();
            $table->integer('length',false,6)->default(0);
            $table->integer('height',false,6)->default(0);
            $table->integer('width',false,6)->default(0);
            $table->string('promotion')->default(\App\Models\Product::NO);

            $table->foreign('category_id')->references('id')->on('categories')->cascadeOnDelete();
            $table->foreign('subcategory_id')->references('id')->on('sub_categories')->cascadeOnDelete();
            $table->foreign('third_category_id')->references('id')->on('third_sub_categories')->cascadeOnDelete();
            $table->foreign('fourth_category_id')->references('id')->on('fourth_sub_categories')->cascadeOnDelete();
            $table->foreign('brand_id')->references('id')->on('brands')->cascadeOnDelete();
            $table->foreign('pack_size_unit_id')->references('id')->on('pack_size_units')->cascadeOnDelete();
            $table->foreign('origin_id')->references('id')->on('origins')->cascadeOnDelete();
            $table->foreign('length_unit_id')->references('id')->on('length_units')->cascadeOnDelete();
            $table->foreign('weight_unit_id')->references('id')->on('weight_units')->cascadeOnDelete();
            $table->foreign('vat_tax_id')->references('id')->on('vat_taxes')->cascadeOnDelete();

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
        Schema::table('products',function (Blueprint $table){

            $table->dropForeign(['publisher_id']);
            $table->dropForeign(['language_id']);
            $table->dropForeign(['country_id']);

            $table->dropForeign(['category_id']);
            $table->dropForeign(['subcategory_id']);
            $table->dropForeign(['third_category_id']);
            $table->dropForeign(['fourth_category_id']);
            $table->dropForeign(['brand_id']);
            $table->dropForeign(['pack_size_unit_id']);
            $table->dropForeign(['origin_id']);
            $table->dropForeign(['weight_unit_id']);
            $table->dropForeign(['length_unit_id']);
            $table->dropForeign(['vat_tax_id']);
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);
        });

        Schema::dropIfExists('products');
    }
}
