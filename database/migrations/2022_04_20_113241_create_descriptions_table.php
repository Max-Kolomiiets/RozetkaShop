<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('descriptions', function (Blueprint $table) {
            $table->id();
            
            $table->string("state", 6);
            $table->char("ean", 13);
            $table->string("description", 2048);
            $table->timestamp("added_at");
            
            $table->foreignId("product_id");
            $table->foreign("product_id")->references("id")->on("products")->onDelete("cascade")->onUpdate("cascade");

            $table->foreignId("country_id");
            $table->foreign("country_id")->references("id")->on("countries")->onDelete("restrict")->onUpdate("cascade");

            $table->foreignId("logistic_parameters_id");
            $table->foreign("logistic_parameters_id")->references("id")->on("logistic_parameters")->onDelete("restrict")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('descriptions');
    }
}
