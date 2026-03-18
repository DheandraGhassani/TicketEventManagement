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
        Schema::create('e_ticketss', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_code')->unique();
            $table->text('qr_code_data');
            $table->enum('status', ['valid', 'scanned', 'void'])->default('valid');
            $table->dateTime('scanned_at')->nullable();
            $table->foreignId('scanned_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('order_items_id')->constrained('order_items')->onDelete('cascade');
            $table->foreignId('users_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('events_id')->constrained('events')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('e_ticketss');
    }
};
