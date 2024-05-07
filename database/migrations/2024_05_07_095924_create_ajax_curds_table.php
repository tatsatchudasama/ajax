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
        Schema::create('ajax_curds', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('price_percentage', 5, 2)->nullable();
            $table->decimal('total', 5, 2)->nullable();
            $table->date('date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ajax_curds');
    }
};
