<?php

namespace App\Http\Controllers;

use App\Http\Services\BookListRequest;
use App\Http\Services\BooksService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BooksController extends Controller
{
    public function __construct()
    {
    }

    public function list(Request $request, BooksService $booksService)
    {
        $validator = Validator::make($request->all(), [
            'author' => 'string',
            'published_before' => 'date_format:Y-m-d',
            'published_after' => 'date_format:Y-m-d|before:published_before',
            'language' => 'exists:languages,short_code',
        ]);

        if($validator->fails()){
            return response()->json($validator->messages(), 400);
        }

        try{
            return response()->download(
                $booksService->getListInCsv(
                    new BookListRequest(
                        $request->author,
                        $request->published_before,
                        $request->published_after,
                        $request->language
                    )
                )
            )->deleteFileAfterSend(true);
        }catch(\Exception $exception){
            return response()->json($exception->getMessage(), 400);
        }
    }
}
