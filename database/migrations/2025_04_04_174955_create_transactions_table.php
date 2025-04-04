<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wallet_id')->constrained()->onDelete('cascade'); // Links to Wallet
            $table->enum('type', ['deposit', 'withdrawal']); // Deposit or Withdrawal
            $table->decimal('amount', 15, 2); // Transaction Amount
            $table->string('reference')->nullable(); // Optional reference (e.g., Syriatel Cash)
            $table->string('status')->default('pending'); // e.g., pending, completed, failed
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
