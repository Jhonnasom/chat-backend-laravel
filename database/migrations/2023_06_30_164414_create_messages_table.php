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

            $table->foreignId('receiver_id')->constrained('users');
            $table->foreignId('sender_id')->constrained('users');
            $table->foreignId('channel_id')->nullable()->constrained('channels');
            $table->text('message');
            $table->binary('read')->default(0);
            $table->text('uuid')->nullable();
            $table->binary('first')->default(0);
            $table->timestamps();
        });
    }
};
