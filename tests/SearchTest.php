<?php

namespace Tests;

use App\Http\Controllers\SearchController;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class SearchTest extends TestCase
{
    /**
     * @return void
     */
    public function test_that_assert_response_is_ok()
    {
        $response = $this->get('/search/?q=deadwood');

        $this->assertEquals('200', $response->response->status());

    }

    /**
     * @return void
     */
    public function test_that_request_method_is_get(){

        $response = $this->post('/search/?q=deadwood', ['q' => 'deadwood']);

        $this->assertEquals('405', $response->response->status());

    }

    /**
     * @return void
     */
    public function test_that_search_have_right_result()
    {
        $search = new SearchController();

        $results = $search->getShow('deadwood');

        $this->assertCount(1, $results);
        $this->assertObjectHasAttribute('name', $results[0]->show);
        $this->assertEquals('Deadwood', $results[0]->show->name);
    }
}
