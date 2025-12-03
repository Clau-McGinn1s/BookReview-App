@extends('layouts.app')
@section('content')
    <h1 class='mb-2 text-2xl'>Book Search</h1>
    <form class='flex mb-3  space-x-3' method='GET' action="{{route('books.index')}}">
        <input class=' grow h-10 pl-2 shadow placeholder:text-blue-300' type="text" name="title" placeholder='Search by Title'
            value="{{ request('title')}}"/>
        <input type='hidden' name='filter' value='{{ request('filter') }}'/>
        <button class='btn h-10' type='submit'>Search</button>
        <a class='btn h-10' href='{{ route('books.index') }}'>Clear Search</a>
    </form>

    <div class='filter-container mb-4 flex'>
        @php
            $filters = [
                '' => 'Latest',
                'popular_last_month' => 'Popular Last Month',
                'popular_last_6months' => 'Popular Last 6 Months',
                'highestScore_last_month' => 'Highest Score Last Month',
                'highestScore_last_6months' => 'Highest Score 6 Months',
            ];
        @endphp 
        @foreach ($filters as $key => $label)
            <a @class(['filter-item', 'filter-item-active' => request('filter') === $key || (request('filter') === null && $label === 'Latest')]) 
                href='{{ route('books.index', [...request()->query(), 'filter' => $key]) }}'>{{$label}}</a>
        @endforeach
    </div>

    <ul>
        @forelse ($books as $book)
            <li class="mb-4">
                <div class="book-item">
                    <div
                    class="flex flex-wrap items-center justify-between">
                    <div class="w-full flex-grow sm:w-auto">
                        <a href="{{route('books.show', $book)}}" class="book-title">{{$book->title}}</a>
                        <span class="book-author">by {{$book->author}}</span>
                    </div>
                    <div>
                        <div class="book-rating">
                            <x-star-review :score="$book->reviews_avg_score"/>
                        </div>
                        <div class="book-review-count">
                        out of {{ $book->reviews_count }} {{Str::plural('review', $book->reviews_count )}}
                        </div>
                    </div>
                     </div>
                </div>
            </li>
        @empty
            <li class="mb-4">
                <div class="empty-book-item">
                    <p class="empty-text">No books found</p>
                    <a href="{{ route('books.index') }}" class="reset-link">Reset criteria</a>
                </div>
            </li>
        @endforelse
        @isset($books)
            <div>
                {{ $books->links() }}
            </div>
        @endisset
    </ul>
@endsection
