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
        Schema::create('croatian_tags', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->text('title');
            $table->string('slug')->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('croatian_tags', function (Blueprint $table) {
            $table->dropColumn('title');
            $table->dropUnique('tags_slug_unique'); 
            $table->dropColumn('slug');
        });
        Schema::dropIfExists('croatian_tags');
    }
};
