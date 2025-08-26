<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('procurement_requests', function (Blueprint $table) {
        $table->id();
        $table->enum('type_request', ['new_request', 'restock']);
        $table->unsignedBigInteger('material_id')->nullable(); // untuk restock
        $table->string('item_name')->nullable(); // untuk new_request
        $table->integer('quantity');
        $table->text('reason')->nullable();
        $table->string('photo')->nullable(); // path foto dari storage
        $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
        $table->unsignedBigInteger('requested_by'); // user.id yang request
        $table->unsignedBigInteger('approved_by')->nullable(); // user.id yang approve
        $table->timestamps();

        // foreign keys (pastikan tabel users & inventories ada)
        $table->foreign('requested_by')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
        $table->foreign('material_id')->references('id')->on('inventories')->onDelete('set null');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('procurement_requests');
    }
};
