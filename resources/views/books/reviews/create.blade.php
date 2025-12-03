@extends('layouts.app')
@section('content')
    <div class='flex mb-2 space-x-4 items-center '>
        <a class=" gap-10 book-title" href='{{ route('books.show', $book)}}'>🠈</a>
        <h1 class="text-2xl">New Review for {{ $book->title }}</h1>
    </div>

    <form method='POST' action='{{ route('books.reviews.store', $book) }}'>
        @csrf
        <div class='flex flex-col'>
            <label class='text-lg pr-16' for='score'>
                Score
            </label>
            <select class='grow p-2' text='number' name='score' id='score'>
                <option value=''>Select an Score</option>
                <option value='1'>1</option>
                <option value='2'>2</option>
                <option value='3'>3</option>
                <option value='4'>4</option>
                <option value='5'>5</option>

            </select>
            @error('score')
                <p class='error-msg'>{{$message}}</p>
            @enderror
        </div>
        <div class='flex flex-col'>
            <label class='text-lg pr-16'  for='review'>
                Review
            </label>
            <textarea class='grow p-2' name='review' id='review' 
            rows='2' ></textarea>
            @error('review')
                <p class='error-msg'>{{$message}}</p>
            @enderror
        </div>

         <button class='btn' type='Submit'>
            Add Review
         </button>
    </form>
@endsection