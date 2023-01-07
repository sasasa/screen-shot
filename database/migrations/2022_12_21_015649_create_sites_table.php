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
        Schema::create('sites', function (Blueprint $table) {
            $table->id();
            $table->string('url')->unique()->comment('URL');
            $table->string('title')->comment('サイトのタイトル')->nullable();
            $table->string('description')->comment('サイトの要約')->nullable();
            $table->longText('body')->comment('サイトの内容')->nullable();
            $table->string('vibrant')->nullable();
            $table->string('dark_vibrant')->nullable();
            $table->string('light_vibrant')->nullable();
            $table->string('muted')->nullable();
            $table->string('dark_muted')->nullable();
            $table->string('light_muted')->nullable();
            // $table->string('mode_color')->comment('1番目に使われている色')->nullable();
            // $table->string('second_color')->comment('2番目に使われている色')->nullable();
            // $table->string('third_color')->comment('3番目に使われている色')->nullable();
            // $table->string('darkest_color')->comment('一番暗い色')->nullable();
            // $table->string('brightest_color')->comment('一番明るい色')->nullable();
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
        Schema::dropIfExists('sites');
    }
};
