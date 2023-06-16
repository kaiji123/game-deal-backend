<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDealsTable extends Migration
{
    public function up()
    {
        Schema::create('deals', function (Blueprint $table) {
            $table->string('dealID', 255)->primary();
            $table->string('storeID', 255)->nullable();
            $table->string('gameID', 255)->nullable();
            $table->string('thumb', 255)->nullable();
            $table->string('title', 255)->nullable();
            $table->string('salePrice', 255)->nullable();
            $table->string('normalPrice', 255)->nullable();
            $table->string('isOnSale', 255)->nullable();
            $table->string('savings', 255)->nullable();
            $table->string('metacriticScore', 255)->nullable();
            $table->string('steamRatingText', 255)->nullable();
            $table->string('steamRatingPercent', 255)->nullable();
            $table->string('steamRatingCount', 255)->nullable();
            $table->string('steamAppID', 255)->nullable();
            $table->bigInteger('releaseDate')->nullable();
            $table->bigInteger('lastChange')->nullable();
            $table->string('dealRating', 255)->nullable();
            $table->string('internalName', 255)->nullable();
            $table->string('metacriticLink', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('deals');
    }
}
