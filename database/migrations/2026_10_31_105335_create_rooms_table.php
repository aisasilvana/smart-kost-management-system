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
    Schema::create('rooms', function (Blueprint $table) {
        $table->id();
        $table->foreignId('kost_id')->constrained()->cascadeOnDelete();
        $table->string('room_number');
        $table->decimal('monthly_price', 12, 2);
        $table->string('status')->default('available');
        $table->timestamps();

        $table->unique(['kost_id', 'room_number']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
