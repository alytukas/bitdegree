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
        Schema::create('coinmarketcaps', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price', 18, 8);
            $table->decimal('market_cap', 18, 2)->nullable();
            $table->decimal('volume_24h', 18, 2)->nullable();
            $table->decimal('volume_change_24h', 18, 2)->nullable();
            $table->text('last_updated')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coinmarketcaps');
    }
};
