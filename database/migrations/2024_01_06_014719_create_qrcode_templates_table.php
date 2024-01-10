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
        Schema::create('qrcode_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name')
                ->index();
            $table->string('template_path')
                ->nullable();
            $table->string('file_name_template', 50)
                ->nullable();
            $table->string('logo_path', 255)
                ->nullable();
            $table->string('color', 50)
                ->default('#000000');
            $table->string('bg_color', 50)
                ->default('#ffffff');
            $table->integer('size')
                ->default(300);
            $table->boolean('is_bordered')
                ->default(true);
            $table->boolean('is_transparent')
                ->default(false);
            $table->boolean('has_code')
                ->default(false);
            $table->foreignId('created_by')
                ->nullable();
            $table->foreignId('updated_by')
                ->nullable();
            $table->timestamps();

            /* INDEX */
            $table->index('id', 'idx_id');

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
        Schema::dropIfExists('qrcode_templates');
    }
};
