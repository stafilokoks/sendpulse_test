<?php


namespace App\Exceptions;


use Throwable;

class AuthorNotExistException extends \Exception
{
    public function __construct($message = "", $code = 400, Throwable $previous = null)
    {
        $message = "Author with code $message doesn't exist";
        parent::__construct($message, $code, $previous);
    }
}
