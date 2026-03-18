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
        Schema::create('waiting_lists_has_notifications', function (Blueprint $table) {
            $table->foreignId('waiting_lists_id')->constrained('waiting_lists')->onDelete('cascade');
            $table->foreignId('notifications_id')->constrained('notifications')->onDelete('cascade');
            $table->primary(['waiting_lists_id', 'notifications_id'], 'waiting_list_notification_primary');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('waiting_lists_has_notifications');
    }
};
