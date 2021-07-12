<?php


namespace App\Http\Services;


class BookListRequest
{
    public $authorCode;
    public $publishedBefore;
    public $publishedAfter;
    public $languageCode;

    public function __construct(
        ?string $authorCode,
        ?string $publishedBefore,
        ?string $publishedAfter,
        ?string $languageCode
    )
    {
        $this->authorCode   = $authorCode;
        $this->publishedBefore   = $publishedBefore;
        $this->publishedAfter   = $publishedAfter;
        $this->languageCode = $languageCode;
    }
}
