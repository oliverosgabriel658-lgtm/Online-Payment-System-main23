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
    Schema::create('paythru_users', function (Blueprint $table) {
        $table->id(); // This gives every user a unique ID number
        $table->string('full_name'); // To store their name
        $table->string('email')->unique(); // To store their email (no duplicates allowed!)
        $table->string('mpin'); // To store their 6-digit login PIN
        $table->decimal('balance', 15, 2)->default(0.00); // Give them ₱500 to start with!
        $table->timestamps(); // This automatically records when they joined
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paythru_users');
    }
};
