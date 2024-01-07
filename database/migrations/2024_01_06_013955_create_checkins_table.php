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
        Schema::create('checkins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')
                ->nullable(false);
            $table->string('event_code', 200)
                ->nullable(false);
            $table->foreignId('user_id')
                ->nullable();
            $table->string('device_name', 255);
            $table->string('qrcode', 200);
            $table->string('client_name', 255);
            $table->json('params');
            $table->dateTime('scan_time');
            $table->string('note', 255);
            $table->string('type', 50);
            $table->string('status', 50)
                ->default('ACTIVE')
                ->nullable(false);
            $table->foreignId('created_by')
                ->nullable();
            $table->foreignId('updated_by')
                ->nullable();
            $table->timestamps();

            /* INDEX */
            $table->index('id', 'idx_id');
            $table->index('event_id', 'idx_event_id');
            $table->index('event_code', 'idx_event_code');
            $table->index('qrcode', 'idx_qrcode');

            /* RELATIONSHIP */
            $table->foreign('event_id')
                ->references('id')
                ->on('events')
                ->onDelete('restrict');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
            $table->foreign('created_by')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
            $table->foreign('updated_by')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checkins');
    }
};
