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
        Schema::create('payments_has_notifications', function (Blueprint $table) {
            $table->foreignId('payments_id')->constrained('payments')->onDelete('cascade');
            $table->foreignId('notifications_id')->constrained('notifications')->onDelete('cascade');
            $table->primary(['payments_id', 'notifications_id'], 'payment_notification_primary');        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments_has_notifications');
    }
};
