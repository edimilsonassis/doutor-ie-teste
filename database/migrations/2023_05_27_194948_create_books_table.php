<?php

use App\Models\v1\Book as MD;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id(MD::COLUMN_ID);
            $table->foreignId(MD::COLUMN_USUARIO_PUBLICADOR_ID)->constrained('users');
            $table->string(MD::COLUMN_TITULO, 100)->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};