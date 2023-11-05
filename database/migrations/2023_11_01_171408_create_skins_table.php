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
        Schema::create('skins', function (Blueprint $table) {
            $table->id();
            $table->integer('code') ->index();
            $table->foreignId('user_id') -> constrained() -> onDelete('restrict') ->onUpdate('cascade');
            $table->boolean('paid');
            $table->boolean('active');
            $table->string('colorstatus');
            $table->boolean('gadgetstatus');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skins');
    }
}; 