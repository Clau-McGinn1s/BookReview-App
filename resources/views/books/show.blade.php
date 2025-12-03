@extends('layouts.app')

@section('content')
  <div class="mb-4">
    <div class='flex mb-2 space-x-4 items-center '>
        <a class=" gap-10 book-title" href='/'>🠈</a>
        <h1 class="gap-10 text-2xl">{{ $book->title }}</h1>
    </div>

    <div class="book-info">
      <div class="book-author mb-4 text-lg font-semibold">by {{ $book->author }}</div>
      <div class="book-rating flex items-center">
        <div class="mr-2 text-sm font-medium text-slate-700">
          <x-star-review :score="$book->reviews_avg_score"/>
        </div>
        <span class="book-review-count text-sm text-gray-500">
          {{ $book->reviews_count }} {{ Str::plural('review', $book->reviews_count ) }}
        </span>
      </div>
    </div>
  </div>

  <div>
    <h2 class="mb-4 text-xl font-semibold">Reviews</h2>
    <a class='btn mb-4' href='{{ route('books.reviews.create', $book) }}'>＋ Add New Review</a>
    <ul class='mt-4'>
      @forelse ($book->reviews as $review)
        <li class="book-item mb-4">
          <div>
            <div class="mb-2 flex items-center justify-between">
              <div class="font-semibold">
                <x-star-review :score="$review->score"/>
              </div>
              <div class="book-review-count">
                {{ $review->created_at->format('M j, Y') }}</div>
            </div>
            <p class="text-gray-700">{{ $review->review }}</p>
          </div>
        </li>
      @empty
        <li class="mb-4">
          <div class="empty-book-item">
            <p class="empty-text text-lg font-semibold">No reviews yet</p>
          </div>
        </li>
      @endforelse
    </ul>
  </div>
@endsection