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
        Schema::create('productions', function (Blueprint $table) {
            $table->id();
            $table->string('register_url')->unique();
            $table->boolean('is_opt_in')->default(false);
            $table->timestamp('confirm_at')->nullable();
            $table->timestamp('lock_at')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->tinyInteger('fail_count')->unsigned()->default(0);
            $table->timestamp('pass_update_date')->nullable();
            $table->rememberToken();
            $table->tinyInteger('company_type')->unsigned()->comment('会社形態：1:法人,2:任意団体,3:個人・個人事業')->nullable();
            $table->string('name')->comment('会社名')->nullable();
            $table->string('kana')->comment('会社名カナ')->nullable();
            $table->string('representative')->comment('代表者')->nullable();
            $table->string('inquiry_email')->unique()->comment('お問い合わせメールアドレス')->nullable();
            $table->string('postal')->comment('郵便番号')->nullable();
            $table->string('address')->comment('住所')->nullable();
            $table->string('phone')->comment('電話番号')->nullable();
            $table->string('url')->comment('ホームページURL')->nullable();
            $table->tinyInteger('staff')->comment('スタッフ数：1人、2人～5人、6人～9人、10人～19人、20人～49人、50人～99人、100人以上')->nullable();
            $table->text('achievement')->comment('主な実績')->nullable();
            $table->text('introduction')->comment('会社紹介文')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('productions');
    }
};
