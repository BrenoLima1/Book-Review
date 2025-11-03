<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index(Request $request)
{
    $title = $request->input('title');
    $sort = $request->input('sort', 'desc'); // padrão: maior nota primeiro

    $books = Book::when($title, function ($query, $title) {
                        return $query->where('title', 'like', "%{$title}%");
                    })
                    ->withAvg('reviews', 'rating')
                    ->withCount('reviews')
                    ->orderBy('reviews_avg_rating', $sort)
                    ->paginate(10) // 👈 aqui entra a paginação
                    ->appends(['title' => $title, 'sort' => $sort]); // mantém filtros na navegação

    return view('books.index', compact('books', 'title', 'sort'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */

public function show(Book $book)
{
    $book->load([
        'reviews',
    ])->loadCount('reviews')
      ->loadAvg('reviews', 'rating');

    return view('books.show', compact('book'));
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
