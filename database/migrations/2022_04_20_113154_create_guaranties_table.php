<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuarantiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guaranties', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedInteger("term");
            $table->string("description", 2048);
            $table->string("url", 2048);

            $table->foreignId("vendor_id");
            $table->foreign("vendor_id")->references("id")->on("vendors")->onDelete("restrict")->onUpdate("cascade");

            $table->foreignId("product_id");
            $table->foreign("product_id")->references("id")->on("products")->onDelete("cascade")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('guaranties');
    }
}
