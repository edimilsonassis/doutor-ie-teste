<?php

use App\Models\v1\BookIndex as MD;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('books_indexes', function (Blueprint $table) {
            $table->id(MD::COLUMN_ID);
            $table->foreignId(MD::COLUMN_LIVRO_ID)->constrained('books');
            $table->foreignId(MD::COLUMN_INDICE_PAI_ID)->nullable()->constrained('books_indexes');
            $table->string(MD::COLUMN_TITULO, 100);
            $table->integer(MD::COLUMN_PAGINA);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books_indexes');
    }
};