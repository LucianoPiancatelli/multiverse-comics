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
        Schema::create('comics', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->enum('universe', ['dc', 'marvel']);
            $table->string('series')->nullable();
            $table->string('writer')->nullable();
            $table->string('artist')->nullable();
            $table->text('description');
            $table->decimal('price', 8, 2);
            $table->unsignedSmallInteger('stock')->default(0);
            $table->date('release_date')->nullable();
            $table->string('cover_image')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comics');
    }
};
