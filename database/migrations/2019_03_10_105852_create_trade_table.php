<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTradeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trades', function (Blueprint $table) {
            $table->increments('trade_id');
            $table->unsignedInteger('product_id')->index('idx_product_id')->nullable(false);
            $table->double('buy_price_value', 16, 8)->nullable(false);
            $table->double('sell_price_value', 16, 8)->nullable();
            $table->decimal('fee', 12, 8)->nullable();
            $table->decimal('counts', 12, 6)->nullable(false);
            $table->double('profit_value', 16, 8)->nullable();
            $table->boolean('is_gain')->nullable()->index('idx_is_gain');
            $table->unsignedInteger('user_id')->nullable()->index('idx_user_id');
            $table->string('note')->nullable();
            $table->timestamp('buy_at')->nullable()->index('idx_buy_at');
            $table->timestamp('sell_at')->nullable()->index('idx_sell_at');
            $table->timestamps();

			/* FOREIGN KEYS */
			$table->foreign('product_id')->references('product_id')->on('products');
			$table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trades');
    }
}
