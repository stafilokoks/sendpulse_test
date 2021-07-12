<?php


namespace App\Http\Services;


use App\Exceptions\AuthorNotExistException;
use App\Http\Infrastructure\CsvFile;
use App\Http\Repositories\AuthorsRepository;
use App\Http\Repositories\BooksRepository;

class BooksService
{
    private $booksRepository;
    private $authorsRepository;

    public function __construct(
        BooksRepository $booksRepository,
        AuthorsRepository $authorsRepository
    )
    {
        $this->booksRepository = $booksRepository;
        $this->authorsRepository = $authorsRepository;
    }

    public function getListInCsv(BookListRequest $bookListRequest) : string
    {
        $authorId = null;
        if ($bookListRequest->authorCode && !$authorId = $this->authorsRepository->idByCode($bookListRequest->authorCode)){
            throw new AuthorNotExistException($bookListRequest->authorCode);
        }

        try {
            return CsvFile::storeToFile($this->booksRepository->listGenerator(
                    $authorId,
                    $bookListRequest->publishedAfter,
                    $bookListRequest->publishedBefore,
                    $bookListRequest->languageCode
                ));
        }catch (\Exception $exception){
            throw new \Exception('Csv file storage error: ' . $exception->getMessage(), 500);
        }
    }
}
