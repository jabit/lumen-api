<?php

namespace Tests;

use App\Http\Controllers\SearchController;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class SearchTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_that_base_endpoint_returns_a_successful_response()
    {
        $this->get('/');

        $this->assertEquals(
            $this->app->version(), $this->response->getContent()
        );
    }

    public function test_that_assert_response_is_ok()
    {
        $response = $this->get('/search/?q=deadwood');
        $this->assertEquals('200', $response->response->status());

    }

    public function test_that_request_method_is_get()
    {
        $search = new SearchController();

        $results = $search->getShow('deadwood');

        $this->assertCount(1, $results);
        //$this->assertContains('show', $results);
    }
}
