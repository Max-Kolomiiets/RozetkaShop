<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories_attributes', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId("attribut_id");
            $table->foreign("attribut_id")->references("id")->on("attributes")->onDelete("cascade")->onUpdate("cascade");

            $table->foreignId("category_id");
            $table->foreign("category_id")->references("id")->on("categories")->onDelete("cascade")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories_attributes');
    }
}
