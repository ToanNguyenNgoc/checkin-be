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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')
                ->nullable(false);
            $table->boolean('is_default')
                ->default(false)
                ->nullable(false);
            $table->string('code', 200);
            $table->string('name', 255);
            $table->string('description', 255);
            $table->string('logo_path', 255);
            $table->string('location', 255);
            $table->boolean('encrypt_file_link')
                ->default(false)
                ->nullable(false);
            $table->dateTime('from_date')
                ->nullable(false);
            $table->dateTime('end_date')
                ->nullable(false);
            $table->json('main_field_template');
            $table->json('custom_field_template');
            $table->json('languages');
            $table->string('contact_name', 255);
            $table->string('contact_email', 255);
            $table->string('contact_phone', 255);
            $table->string('note', 255);
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
            $table->index('company_id', 'idx_company_id');
            $table->index('created_by', 'idx_created_by');
            $table->index('updated_by', 'idx_updated_by');

            /* RELATIONSHIP */
            $table->foreign('company_id')
                ->references('id')
                ->on('companys')
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
        Schema::dropIfExists('events');
    }
};
