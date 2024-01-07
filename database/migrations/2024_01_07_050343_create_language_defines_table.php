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
        Schema::create('language_defines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('language_id')
                ->nullable(false);
            $table->foreignId('event_id')
                ->nullable(false);
            $table->string('keyword');
            $table->string('translate');
            $table->string('type');
            $table->foreignId('created_by')
                ->nullable();
            $table->foreignId('updated_by')
                ->nullable();
            $table->timestamps();

            /* INDEX */
            $table->index('id', 'idx_id');
            $table->index('language_id', 'idx_language_id');
            $table->index('event_id', 'idx_event_id');

            /* RELATIONSHIP */
            $table->foreign('language_id')
                ->references('id')
                ->on('languages')
                ->onDelete('restrict');
            $table->foreign('event_id')
                ->references('id')
                ->on('events')
                ->onDelete('restrict');
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
        Schema::dropIfExists('language_defines');
    }
};
