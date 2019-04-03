<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('product_id');
            $table->char('external_product_id', 30)->unique();
            $table->string('name', 50)->nullable(false);
            $table->string('description')->nullable(true);
            $table->unsignedInteger('from_currency_id')->index('idx_from_currency_id')->nullable(false);
            $table->unsignedInteger('to_currency_id')->index('idx_to_currency_id')->nullable(false);
            $table->timestamps();

            /* FOREIGN KEYS */
			$table->foreign('from_currency_id')->references('currency_id')->on('currencies');
			$table->foreign('to_currency_id')->references('currency_id')->on('currencies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
