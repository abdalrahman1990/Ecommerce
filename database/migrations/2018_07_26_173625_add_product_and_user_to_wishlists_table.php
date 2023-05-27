<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProductAndUserToWishlistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wishlists', function (Blueprint $table) {
            //$table->integer('product_id')->unsigned()->change();
            //$table->integer('user_id')->unsigned()->change();
            $table->foreign('product_id')->references('id')->on('products');
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
        Schema::table('wishlists', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropForeign(['user_id']);
        });
    }
}
