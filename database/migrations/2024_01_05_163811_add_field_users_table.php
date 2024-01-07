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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('company_id')
                ->nullable();
            $table->foreign('company_id')
                ->references('id')
                ->on('companys')
                ->onDelete('restrict');
            $table->foreignId('event_id')
                ->nullable();
            $table->foreign('event_id')
                ->references('id')
                ->on('events')
                ->onDelete('restrict');

            $table->unique(['company_id', 'username']);

            $table->index('id', 'idx_id');
            $table->index('company_id', 'idx_company_id');
            $table->index('event_id', 'idx_event_id');
            $table->index('username', 'idx_username');
            $table->index('email', 'idx_email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
            $table->dropForeign(['event_id']);
            $table->dropUnique(['company_id', 'username']);
            $table->dropUnique(['company_id', 'email']);
            $table->dropColumn(['company_id', 'event_id']);
        });
    }
};
