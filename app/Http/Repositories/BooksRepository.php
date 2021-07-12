<?php


namespace App\Http\Repositories;


use Illuminate\Support\Facades\DB;

class BooksRepository
{
    public function listGenerator(
        $authorId,
        $publishedAfter,
        $publishedBefore,
        $langCode
    )
    {
        return DB::table('books')
            ->when($authorId, function($query) use ($authorId){
                return $query->where('author_id', $authorId);
            })
            ->when(($publishedAfter && !$publishedBefore) , function ($query) use ($publishedAfter){
                return $query->where('published', '>', $publishedAfter);
            })
            ->when((!$publishedAfter && $publishedBefore) , function ($query) use ($publishedBefore){
                return $query->where('published', '<', $publishedBefore);
            })
            ->when(($publishedAfter && $publishedBefore) , function ($query) use ($publishedAfter, $publishedBefore){
                return $query->whereBetween('published', [$publishedAfter, $publishedBefore]);
            })
            ->when($langCode, function ($query) use ($langCode){
                return $query->whereIn(
                    'language_id',
                    DB::table('languages')
                        ->where('short_code', $langCode)->pluck('id')
                );
            })
            ->select(['id', 'name', 'published', 'author_id', 'language_id'])
            ->cursor();
    }
}
