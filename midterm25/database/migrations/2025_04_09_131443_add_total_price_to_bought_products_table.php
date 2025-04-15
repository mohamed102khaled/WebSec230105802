<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTotalPriceToBoughtProductsTable extends Migration
{
    public function up()
    {
        Schema::table('bought_products', function (Blueprint $table) {
            $table->decimal('total_price', 10, 2)->default(0);
        });
    }

    public function down()
    {
        Schema::table('bought_products', function (Blueprint $table) {
            $table->dropColumn('total_price');
        });
    }
}

