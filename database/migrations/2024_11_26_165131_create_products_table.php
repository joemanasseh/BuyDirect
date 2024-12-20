<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->decimal('price', 10, 2);
            $table->integer('minimum_order_quantity')->default(1);
            $table->integer('available_quantity');
            $table->foreignId('manufacturer_id')->constrained('manufacturers')->onDelete('cascade');
            $table->integer('merge_buy_limit')->nullable();
            $table->decimal('merge_buy_price', 10, 2)->nullable();
            $table->integer('merge_buy_quantity')->nullable();
            $table->string('merge_buy_city')->nullable();
            $table->string('product_type'); // 'bulk' or 'merge'
            $table->string('created_by')->nullable(); // Added for audit trail
            $table->string('updated_by')->nullable(); // Added for audit trail
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}
