<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('bought_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('quantity')->default(1);
            $table->decimal('total_price', 10, 2);
            $table->string('status')->default('purchased'); // Status of the purchase
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bought_products');
    }
};

