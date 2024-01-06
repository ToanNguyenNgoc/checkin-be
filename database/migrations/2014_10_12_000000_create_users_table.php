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
            /* $table->enum('admin_level', [0, 1, 2, 3])
                ->default(0); */
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
            $table->dateTime('last_login_at')
                ->nullable();
            $table->timestamps();

            /* RELATIONSHIP */

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
        Schema::dropIfExists('users');
    }
};
