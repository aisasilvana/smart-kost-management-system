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
    Schema::create('payments', function (Blueprint $table) {
        $table->id();
        $table->foreignId('bill_id')->constrained()->restrictOnDelete();
        $table->decimal('amount', 12, 2);
        $table->string('payment_method')->default('bank_transfer');
        $table->string('proof_path')->nullable();
        $table->string('status')->default('pending');
        $table->foreignId('verified_by')
            ->nullable()
            ->constrained('users')
            ->nullOnDelete();
        $table->timestamp('verified_at')->nullable();
        $table->text('rejection_reason')->nullable();
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
