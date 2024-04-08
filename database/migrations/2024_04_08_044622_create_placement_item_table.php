<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('trx_placement_item', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('item_id');
            $table->string('item_code');
            $table->string('item_name');
            $table->unsignedBigInteger('location_id');
            $table->string('location_name');
            $table->integer('qty');
            $table->unsignedBigInteger('user_id');
            $table->string('user_name');
            $table->timestamps();

            // Added foreign key constraint
            $table->foreign('item_id')->references('id')->on('mst_items');
            $table->foreign('location_id')->references('id')->on('mst_locations');
            $table->foreign('user_id')->references('id')->on('mst_users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trx_placement_item');
    }
};
