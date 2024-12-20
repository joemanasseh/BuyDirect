<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('manufacturer_id');
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('logistics_details')->nullable(); // e.g., courier, pickup details
            $table->string('location')->nullable(); // Address or city
            $table->integer('quantity')->default(1); // Quantity bought
            $table->timestamps();

            // Foreign keys
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('manufacturer_id')->references('id')->on('manufacturers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('participants');
    }
}
