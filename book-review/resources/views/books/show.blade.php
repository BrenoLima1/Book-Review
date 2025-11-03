@extends('layouts.app')

@section('content')
  <div class="bg-white shadow rounded-lg p-6">
      <h1 class="text-3xl font-bold text-indigo-700 mb-4">{{ $book->title }}</h1>
      <p class="text-gray-600 mb-2">Author: {{ $book->author }}</p>

      {{-- Média de avaliações --}}
      <div class="mt-4 mb-6">
          <div class="flex items-center">
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
      </div>

      <h2 class="text-xl font-semibold mb-4">Reviews</h2>
      <ul class="space-y-4">
          @forelse ($book->reviews as $review)
              <li class="border-b pb-2">
                  <div class="flex items-center justify-between">
                      <div class="flex items-center">
                          @for ($i = 1; $i <= 5; $i++)
                              @if ($i <= $review->rating)
                                  <svg class="w-4 h-4 text-yellow-500 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                      <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                  </svg>
                              @else
                                  <svg class="w-4 h-4 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                  </svg>
                              @endif
                          @endfor
                      </div>
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
