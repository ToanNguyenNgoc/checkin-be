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
        Schema::create('countrys', function (Blueprint $table) {
            $table->id();
            $table->string('code', 200)
                ->nullable(false);
            $table->string('name')
                ->nullable(false);
            $table->boolean('is_default')
                ->nullable(false);
            $table->string('description')
                ->nullable();
            $table->string('flag_link')
                ->nullable();
            $table->text('alt')
                ->nullable();
            $table->string('status', 50)
                ->default('ACTIVE')
                ->nullable(false);
            $table->timestamps();

            /* INDEX */
            $table->index('id', 'idx_id');
            $table->index('code', 'idx_code');
            $table->index('name', 'idx_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countrys');
    }
};
