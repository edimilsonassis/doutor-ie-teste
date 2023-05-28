<?php

namespace App\Http\Controllers\v1;

use App\Models\v1\Book;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Resources\v1\BookResource;
use App\Models\v1\BookIndex;
use Illuminate\Http\Request;

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

    /**
     * Show the form for creating a new resource.
     */
    public function create(StoreBookRequest $request)
    {
        $data = $request->validated();

        $book = Book::factory()->create($data);

        // SEND MAIL

        return $book;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function import(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, Book $book)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        //
    }
}