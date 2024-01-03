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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_admin')
                ->default(false)
                ->nullable(false);
            $table->date('expire_date', 255)
                ->nullable();
            $table->string('name');
            $table->string('username', 255)
                ->nullable(false)
                ->unique();
            $table->string('email')
                ->nullable(false)
                ->unique();
            $table->timestamp('email_verified_at')
                ->nullable();
            $table->string('password');
            $table->string('type', 50)
                ->default('WEB')
                ->comment('ADMIN/WEB/PDA/PC')
                ->nullable(false);
            $table->string('gate', 50)
                ->comment('Gate/Booth/...')
                ->nullable();
            $table->string('avatar_path', 255)
                ->nullable();
            $table->text('note')
                ->nullable();
            $table->string('status', 50)
                ->default('NEW')
                ->nullable(false);
            $table->foreignId('created_by')
                ->nullable();
            $table->foreignId('updated_by')
                ->nullable();
            $table->rememberToken();
            $table->timestamps();

            /* RELATIONSHIP */

            $table->foreign('created_by')
                ->references('id')
                ->on('users');

            $table->foreign('updated_by')
                ->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
