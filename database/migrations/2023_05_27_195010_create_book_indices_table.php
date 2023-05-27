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
        Schema::create('book_indices', function (Blueprint $table) {
            $table->id(MD::COLUMN_ID);
            $table->foreignId(MD::COLUMN_LIVRO_ID)->constrained('books');
            $table->foreignId(MD::COLUMN_INDICE_PAI_ID)->nullable()->constrained('book_indices');
            $table->string(MD::COLUMN_TITULO, 100)->unique();
            $table->integer(MD::COLUMN_PAGINA);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_indices');
    }
};