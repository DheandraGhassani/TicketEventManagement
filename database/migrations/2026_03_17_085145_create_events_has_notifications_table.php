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
        Schema::create('events_has_notifications', function (Blueprint $table) {
            $table->foreignId('events_id')->constrained('events')->onDelete('cascade');
            $table->foreignId('notifications_id')->constrained('notifications')->onDelete('cascade');
            $table->primary(['events_id', 'notifications_id'], 'event_notification_primary');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events_has_notifications');
    }
};
