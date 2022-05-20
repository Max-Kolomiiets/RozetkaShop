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
            $table->string("name", 200);
            $table->string("alias", 200);

            $table->foreignId("category_id");
            $table->foreign("category_id")->references("id")->on("categories")->onDelete("restrict")->onUpdate("cascade");

            $table->foreignId("vendor_id");
            $table->foreign("vendor_id")->references("id")->on("vendors")->onDelete("restrict")->onUpdate("cascade");
            
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
        Schema::dropIfExists('products');
    }
}
