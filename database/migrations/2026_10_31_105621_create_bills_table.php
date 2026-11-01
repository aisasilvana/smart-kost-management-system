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
    Schema::create('bills', function (Blueprint $table) {
        $table->id();
        $table->foreignId('room_assignment_id')
            ->constrained()
            ->restrictOnDelete();

        $table->date('billing_month');
        $table->decimal('amount', 12, 2);
        $table->date('due_date');
        $table->string('status')->default('unpaid');
        $table->timestamps();

        $table->unique([
            'room_assignment_id',
            'billing_month'
        ]);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};
