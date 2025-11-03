@extends('layouts.app')

@section('content')
  <div class="bg-white shadow rounded-lg p-6">
      <h1 class="text-3xl font-bold text-indigo-700 mb-4">{{ $book->title }}</h1>
      <p class="text-gray-600 mb-2">Author: {{ $book->author }}</p>

      <div class="mt-4 mb-6">
          <span class="text-yellow-500 font-bold">
              ⭐ {{ number_format($book->reviews_avg_rating, 1) }}
          </span>
          <span class="text-sm text-gray-500">
              ({{ $book->reviews_count }} {{ Str::plural('review', $book->reviews_count) }})
          </span>
      </div>

      <h2 class="text-xl font-semibold mb-4">Reviews</h2>
      <ul class="space-y-4">
          @forelse ($book->reviews as $review)
              <li class="border-b pb-2">
                  <div class="flex items-center justify-between">
                      <span class="text-yellow-500">⭐ {{ $review->rating }}</span>
                      <span class="text-sm text-gray-500">{{ $review->created_at->format('m/d/Y') }}</span>
                  </div>
                  <p class="text-gray-700 mt-1">{{ $review->review }}</p>
              </li>
          @empty
              <li class="text-gray-500">No reviews yet.</li>
          @endforelse
      </ul>

      <a href="{{ route('books.index') }}" class="mt-6 inline-block text-indigo-600 hover:underline">
          ← Back to list
      </a>
  </div>
@endsection
