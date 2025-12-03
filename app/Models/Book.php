<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'author'];

    public function reviews() : HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function scopeWithReviewsCount(Builder $query, $from= null, $to= null):Builder{
        return $query->withCount(['reviews' 
            => fn(Builder $q) 
            => $this->dateRangeFilterfunction($q, $from, $to)]);
    }

    public function scopeWithAvgScore(Builder $query, $from= null, $to= null){
          return $query->withAvg(['reviews' 
            => fn(Builder $q) 
            => $this->dateRangeFilterfunction($q, $from, $to)], 
            'score');
    }

    public function scopeTitle(Builder $query, string $keyWord, $from= null, $to= null):Builder
    {
       $this->dateRangeFilterfunction($query, $from, $to);
       return $query->where('title', 'LIKE', '%' . $keyWord . '%');   
    }

    public function scopePopular(Builder $query, $from= null, $to= null):Builder
    {
        return $query->withReviewsCount($from, $to)
        ->orderBy('reviews_count', 'desc');
    }

     public function scopeHighestScore(Builder $query, $from= null, $to= null):Builder
    {
        return $query->withAvgScore($from, $to)
        ->orderBy('reviews_avg_score', 'desc');
    }

    public function scopeMinReviews(Builder $query, int $minCount):Builder{
        return $query->having('reviews_count', '>=', $minCount);
    }

    public function scopePopularLastMonth(Builder $query){
        return $query->popular(now()->subMonth(), now())
            ->highestScore(now()->subMonth(), now())
            ->minReviews(2);
    }

     public function scopePopularLast6Months(Builder $query){
        return $query->popular(now()->subMonth(7), now())
            ->highestScore(now()->subMonth(7), now())
            ->minReviews(4);
    }

    public function scopeHighestScoreLastMonth(Builder $query){
        return $query->highestScore(now()->subMonth(), now())
            ->popular(now()->subMonth(), now())
            ->minReviews(2);
    }

      public function scopeHighestScoreLast6Months(Builder $query){
        return $query->highestScore(now()->subMonth(7), now())
            ->popular(now()->subMonth(7), now())
            ->minReviews(4);
    }


    private function dateRangeFilterfunction (Builder $query,  $from= null, $to= null)
    {
        if($from && !$to){
            $query->where('created_at', '>=', $from);
        }
        else if(!$from && $to){
            $query->where('created_at', '<=', $to);
        }
        else if($from && $to){
            $query->whereBetween('created_at', [$from, $to]);
        }
    }

     protected static function booted():void
    {
        static::updated(fn (Book $book)=>cache()->forget('book.show:' . $book->id . ':reviews'));
        static::deleted(fn (Book $book)=>cache()->forget('book.show:' . $book->id . ':reviews'));
        static::created(fn (Book $book)=>cache()->forget('book.show:' . $book->id . ':reviews'));
    }
}
