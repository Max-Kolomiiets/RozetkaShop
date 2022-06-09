<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCharacteristicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('characteristics', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId("product_id");
            $table->foreign("product_id")->references("id")->on("products")->onDelete("cascade")->onUpdate("cascade");

            $table->foreignId("attribute_id");
            $table->foreign("attribute_id")->references("id")->on("attributes")->onDelete("cascade")->onUpdate("cascade");

            $table->string("value", 2048)->default("def val");
            $table->string("alias", 2048)->default("def_val");
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
        Schema::dropIfExists('characteristics');
    }
}
