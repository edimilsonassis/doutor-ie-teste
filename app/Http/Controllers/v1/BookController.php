<?php

namespace App\Http\Controllers\v1;

use App\Http\Requests\StoreBookIndexRequest;
use App\Models\v1\Book;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Resources\v1\BookResource;
use App\Models\v1\BookIndex;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $url_title   = $request->query('titulo');
        $url_indexes = $request->query('titulo_do_indice');

        $books = Book::with(Book::RELATION_USER);

        $books->with(BookIndex::RELATION_BOOK_INDEXES);

        $books->where(function ($query) use ($url_title, $url_indexes) {
            if ($url_title) {
                $query->where(Book::COLUMN_TITULO, 'like', "%$url_title%");
            }

            if ($url_indexes) {
                $query->whereHas(BookIndex::RELATION_PARENTS, function ($subQuery) use ($url_indexes) {
                    $subQuery->where(BookIndex::COLUMN_TITULO, 'like', "%$url_indexes%"); //->with(BookIndex::RELATION_PARENTS);
                });
            } else {
                $query->with(BookIndex::RELATION_BOOK_INDEXES);
            }
        });

        // echo '<pre>';
        // echo (
        //     $books->toSql()
        // );
        // echo '</pre>';
        // exit;

        return BookResource::collection($books->paginate(5));
    }

    private function recursiveCreateIndexes(array $indexes, $bookId, $parentId = null)
    {
        foreach ($indexes as $indiceData) {
            $indiceRequest = new StoreBookIndexRequest($indiceData);
            $validatedData = $indiceRequest->validated();

            $indice = new BookIndex([
                'livro_id'      => $bookId,
                'indice_pai_id' => $parentId,
                'titulo'        => $validatedData['titulo'],
                'pagina'        => $validatedData['pagina'],
            ]);

            $indice->save();

            if (isset($indiceData['indices'])) {
                $this->createIndices($indiceData['indices'], $bookId, $indice->id);
            }
        }
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
                'titulo'                => $data->titulo,
            ]);

            if ($data->has('indices')) {
                $this->recursiveCreateIndexes($data->indices, $livro->id);
            }

            DB::commit();

            return response()->json($livro, 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Erro ao cadastrar o livro.'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function import(Request $request)
    {
        //
    }
}