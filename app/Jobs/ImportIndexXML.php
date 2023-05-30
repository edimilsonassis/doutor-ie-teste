<?php

namespace App\Jobs;

use App\Models\v1\BookIndex;
use DB;
use Log;
use App\Services\v1\BookIndexService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportIndexXML implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public int $bookId,
        public string $filename
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $file = storage_path("app/$this->filename");

        if (!file_exists($file)) {
            Log::error("Arquivo não encontrado: $file");
        }

        $xmlString = file_get_contents($file);

        $xml = simplexml_load_string($xmlString);

        $convertedArray = [];
        foreach ($xml as $item) {
            $convertedArray[] = BookIndexService::recursiveConverteXML($item);
        }

        Log::info("Importação XML: " . json_encode($convertedArray));

        DB::beginTransaction();
        BookIndex::where(BookIndex::COLUMN_LIVRO_ID, $this->bookId)->delete();
        BookIndexService::recursiveCreateIndexes($convertedArray, $this->bookId);
        DB::commit();
    }
}