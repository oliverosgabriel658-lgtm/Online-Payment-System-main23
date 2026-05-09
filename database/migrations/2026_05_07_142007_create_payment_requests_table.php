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
       Schema::create('payment_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('requester_id')->constrained('paythru_users');
            $table->string('recipient_email');
            $table->decimal('amount', 15, 2);
            $table->decimal('usd_equivalent', 15, 2)->nullable(); // Add this for the Currency API
            $table->text('reason');
            $table->date('due_date')->nullable();
            $table->enum('status', ['Pending', 'Paid', 'Cancelled'])->default('Pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_requests');
    }
};