<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->morphs('notifiable');
            $table->string('channel'); // mail, sms
            $table->string('recipient')->nullable(); // email or phone
            $table->string('subject')->nullable();
            $table->text('body')->nullable();
            $table->json('data')->nullable();
            $table->string('status')->default('sent'); // queued, sent, delivered, failed
            $table->string('provider_message_id')->nullable();
            $table->text('error')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamps();

            $table->index(['tenant_id', 'channel']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};


