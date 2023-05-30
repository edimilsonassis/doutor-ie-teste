<?php

namespace App\Http\Controllers\v1;

use Exception;
use App\Jobs\ImportIndexXML;
use App\Models\v1\Book;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\StoreBookRequest;
use App\Http\Resources\v1\BookResource;
use App\Services\v1\BookIndexService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $urlBookTitle  = $request->query('titulo');
        $urlIndexTitle = $request->query('titulo_do_indice');

        $livros = Book::with([
            'user'
        ]);

        if ($urlBookTitle) {
            $livros->where('titulo', 'LIKE', "%{$urlBookTitle}%");
        }

        if ($urlIndexTitle) {
            $livros->with([
                'indexes'               => function ($query) use ($urlIndexTitle) {
                    $query->where('titulo', 'LIKE', "%{$urlIndexTitle}%")
                        ->orWhereHas('parentindexes', function ($query) use ($urlIndexTitle) {
                            $query->where('titulo', 'LIKE', "%{$urlIndexTitle}%");
                        })->with('parentindexes');
                },
                'indexes.parentindexes' => function ($query) use ($urlIndexTitle) {
                    $query->where('titulo', 'LIKE', "%{$urlIndexTitle}%")->with('parentindexes');
                }
            ]);
        } else {
            $livros->with([
                'indexes.subindexes'
            ]);
        }

        return BookResource::collection($livros->paginate());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(StoreBookRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();

            $livro = Book::create([
                'usuario_publicador_id' => auth()->user()->id,
                'titulo'                => $data['titulo'],
            ]);

            if (isset($data['indices'])) {
                BookIndexService::recursiveCreateIndexes($data['indices'], $livro->id);
            }

            DB::commit();

            return response()->json($livro, 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Erro ao cadastrar o livro.'], 500);
        }
    }

    /**
     *  Import XML file
     */
    public function import(Request $request, $livroId)
    {
        $urlBookId = (int) $livroId;

        if (!Book::find($urlBookId)) {
            return response()->json(['error' => 'Livro não encontrado.'], 500);
        }

        if ($request->hasFile('xml')) {
            $file = $request->file('xml');

            if ($file->isValid()) {
                $name = $file->hashName();
                $user = $request->user()->id;

                $filePath = $file->storeAs(
                    "uploads/books/{$urlBookId}/xml/",
                    "user.{$user}.index.{$name}.xml"
                );

                ImportIndexXML::dispatch($urlBookId, $filePath);

                return response()->json(['success' => true, 'path' => $filePath]);
            }
        }

        return response()->json(['error' => 'Nenhum arquivo válido enviado.'], 400);
    }
}