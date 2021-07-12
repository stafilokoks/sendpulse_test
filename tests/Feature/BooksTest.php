<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BooksTest extends TestCase
{

    // Because we have only one endpoint and doesn't have a possibility to create items thru api
    // there is only several features can be tested.

    public function test_success()
    {
        $response = $this->get('api/books/csv?published_after=1990-12-02&published_before=1999-01-01');

        $response->assertStatus(200);
        // checking, if response contain csv file
        $this->assertTrue(strpos($response->headers->get('content-disposition'), '.csv') > 0);

    }

    public function test_after_before()
    {
        $response = $this->get('api/books/csv?published_after=1999-12-02&published_before=1990-01-01');

        // We should get validation error if published_after > published_before
        $response->assertStatus(400);
    }

    public function test_with_wrong_author_code()
    {
        $response = $this->get('api/books/csv?author=wrongcode');

        // We should get 400 response code when not existed author code is provided.
        $response->assertStatus(400);
    }
}
