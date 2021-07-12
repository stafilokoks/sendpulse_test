<?php


namespace App\Http\Infrastructure;

class CsvFile
{
    static function storeToFile(iterable $generator) : string
    {
        $fileName = storage_path() . '/app/' .uniqid() . '.csv';

        $file = fopen($fileName, 'w+');
        foreach($generator as $book)
        {
            fputcsv($file, [
                $book->id,
                $book->name,
                $book->published
            ], ';');
        }

        fclose($file);

        return $fileName;
    }
}
