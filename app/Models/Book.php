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

    public function scopeTitle(Builder $query, string $keyWord, $from= null, $to= null):Builder
    {
       $this->dateRangeFilterfunction($query, $from, $to);
       return $query->where('title', 'LIKE', '%' . $keyWord . '%');   
    }

    public function scopePopular(Builder $query, $from= null, $to= null):Builder
    {
        return $query->withCount(['reviews' 
            => fn(Builder $q) 
            => $this->dateRangeFilterfunction($q, $from, $to)])
            ->orderBy('reviews_count', 'desc');
    }

     public function scopeHighestScore(Builder $query, $from= null, $to= null):Builder
    {
        return $query->withAvg(['reviews' 
            => fn(Builder $q) 
            => $this->dateRangeFilterfunction($q, $from, $to)], 
            'score')->orderBy('reviews_avg_score', 'desc');
    }

    public function scopeMinReviews(Builder $query, int $minCount):Builder{
        return $query->having('reviews_count', '>=', $minCount);
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
}
