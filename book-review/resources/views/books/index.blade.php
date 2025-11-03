@extends('layouts.app')

@section('content')
  <h1 class="mb-6 text-3xl font-bold text-indigo-700">📖 List of Books</h1>

  {{-- Formulário de busca --}}
  <form method="GET" action="{{ route('books.index') }}" class="mb-6 flex space-x-2">
      <input type="text" name="title" value="{{ request('title') }}"
             placeholder="Search by title..."
             class="flex-grow px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500">
      <button type="submit"
              class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
          Search
      </button>
  </form>

  {{-- Lista de livros --}}
  <ul class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse ($books as $book)
      <li class="bg-white shadow rounded-lg p-4 hover:shadow-lg transition">
        <div class="flex flex-col justify-between h-full">
          <div>
            <a href="{{ route('books.show', $book) }}"
               class="text-xl font-semibold text-indigo-600 hover:underline">
               {{ $book->title }}
            </a>
            <p class="text-gray-600">Author: {{ $book->author }}</p>
          </div>
          <div class="mt-4">
            <div class="text-yellow-500 font-bold">
              ⭐ {{ number_format($book->reviews_avg_rating, 1) }}
            </div>
            <div class="text-sm text-gray-500">
              {{ $book->reviews_count }} {{ Str::plural('review', $book->reviews_count) }}
            </div>
          </div>
        </div>
      </li>
    @empty
      <li class="col-span-full text-center bg-white shadow rounded-lg p-6">
        <p class="text-gray-600 mb-2">No books found</p>
        <a href="{{ route('books.index') }}" class="text-indigo-600 hover:underline">
          🔄 Reset search
        </a>
      </li>
    @endforelse
  </ul>
@endsection
