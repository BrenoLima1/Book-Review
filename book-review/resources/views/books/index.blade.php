@extends('layouts.app')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Books</h1>

        <form method="GET" action="{{ route('books.index') }}" class="flex space-x-2">
            {{-- Search field --}}
            <input type="text" name="title" value="{{ $title }}"
                   placeholder="Search by title"
                   class="border rounded px-2 py-1">

            {{-- Sorting --}}
            <select name="sort" onchange="this.form.submit()"
                    class="border rounded px-2 py-1">
                <option value="desc" {{ $sort === 'desc' ? 'selected' : '' }}>
                    Highest rating first
                </option>
                <option value="asc" {{ $sort === 'asc' ? 'selected' : '' }}>
                    Lowest rating first
                </option>
            </select>

            <button type="submit" class="btn">Filter</button>
        </form>
    </div>

    {{-- Listing --}}
    <ul class="space-y-4">
        @foreach ($books as $book)
            <li class="p-4 border rounded shadow bg-white">
                <h2 class="text-xl font-semibold">{{ $book->title }}</h2>
                <p class="text-gray-600">Author: {{ $book->author }}</p>

                {{-- Estrelas da média --}}
                <div class="flex items-center mt-2">
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= round($book->reviews_avg_rating))
                            {{-- Estrela preenchida --}}
                            <svg class="w-5 h-5 text-yellow-500 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @else
                            {{-- Estrela vazia --}}
                            <svg class="w-5 h-5 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @endif
                    @endfor
                    <span class="ml-2 text-yellow-600 font-bold">
                        {{ number_format($book->reviews_avg_rating, 1) }}
                    </span>
                    <span class="ml-2 text-sm text-gray-500">
                        ({{ $book->reviews_count }} {{ Str::plural('review', $book->reviews_count) }})
                    </span>
                </div>

                <a href="{{ route('books.show', $book) }}" class="text-indigo-600 hover:underline mt-2 inline-block">
                    View details
                </a>
            </li>
        @endforeach
    </ul>

    <div class="mt-6">
        {{-- Mobile: simple pagination --}}
        <div class="sm:hidden">
            {{ $books->onEachSide(1)->links('pagination::simple-tailwind') }}
        </div>

        {{-- Desktop: full pagination --}}
        <div class="hidden sm:block">
            {{ $books->onEachSide(1)->links() }}
        </div>
    </div>
@endsection
