<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogisticParametersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logistic_parameters', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger("packing_weight");
            $table->unsignedInteger("packing_height");
            $table->unsignedInteger("packing_width");
            $table->unsignedInteger("packing_depth");
            $table->unsignedInteger("packages_quantity");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logistic_parameters');
    }
}
