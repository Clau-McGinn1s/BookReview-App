@if($score)
    <div class='flex items-center'>
        @for ($i = 1; $i <= 5; $i++)
            <h2 class='text-4xl text-amber-400'>{{ $i <= round($score) ? '★' : '☆' }}</h2>
        @endfor
        <div>
            <h2 class='pl-2 text-amber-900'>{{number_format($score, 1)}}</h2>
        </div>
    </div>
@else
    <div>
        <h2 class='text-xs'>No score</h2>
    </div>
@endif

