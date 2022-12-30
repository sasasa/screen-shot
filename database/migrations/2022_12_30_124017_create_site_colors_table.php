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
        Schema::create('site_colors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('site_id')->comment('商品ID');
            $table->unsignedInteger('order')->comment('色の比率：並び順にする');
            $table->string('color')->comment("色:'red', 'blue', 'yellow', 'green', 'purple'");
            $table->timestamps();

            $table->foreign('site_id')->references('id')->on('sites');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('site_colors');
    }
};
