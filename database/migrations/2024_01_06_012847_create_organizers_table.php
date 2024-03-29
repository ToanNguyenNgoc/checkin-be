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
        Schema::create('organizers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')
                ->nullable();
            $table->foreignId('event_id')
                ->nullable(false);
            $table->string('event_code', 200)
                ->nullable(false);
            $table->string('qrcode')
                ->nullable(false);
            $table->unique(['event_id', 'qrcode']);
            $table->string('email')
                ->nullable();
            $table->string('phone')
                ->nullable();
            $table->json('custom_fields')
                ->nullable();
            $table->string('type', 50)
                ->default('NORMAL')
                ->nullable(false);
            $table->string('status', 50)
                ->default('NEW')
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
            $table->index('country_id', 'idx_country_id');
            $table->index('qrcode', 'idx_qrcode');

            /* RELATIONSHIP */
            $table->foreign('event_id')
                ->references('id')
                ->on('events')
                ->onDelete('restrict');
            $table->foreign('country_id')
                ->references('id')
                ->on('countrys')
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
        Schema::dropIfExists('organizers');
    }
};
