<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingredient_meal', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ingredient_id');
            $table->unsignedBigInteger('meal_id');
            $table->decimal('quantity', 10, 2)->default(1.00); 
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ingredient_meal');
    }
};
