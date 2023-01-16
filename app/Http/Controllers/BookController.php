<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Resources\Book as ResourcesBook;
use App\Models\Book;
use Illuminate\Support\Facades\Response;

class BookController extends Controller
{
    public function index()
    {
        return ResourcesBook::collection(Book::simplePaginate(10));
    }

    public function store(StoreBookRequest $request)
    {
        $data = $request->validated();

        return new ResourcesBook(Book::create($data));
    }

    public function show(Book $book)
    {
        return new ResourcesBook($book);
    }

    public function update(UpdateBookRequest $request, Book $book)
    {
        $data = $request->validated();

        $book->update($data);

        return new ResourcesBook($book);
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return Response::json([], 202);
    }
}
