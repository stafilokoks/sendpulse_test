<?php


namespace App\Http\Repositories;


use Illuminate\Support\Facades\DB;

class AuthorsRepository
{
    public function idByCode(string $code) : ?string
    {
        return DB::table('authors')->where('code', $code)->value('id');
    }
}
