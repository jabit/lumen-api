<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class SearchController extends Controller
{

    /**
     * deescription.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request){

        if($request->getMethod() == "GET"){
            $q = $request->input('q');

            $searched = Cache::get( 'tvmaze_q' );

            // in case API calls exceed the limit, 20 calls every 10 seconds per IP address
            $off = Cache::get( 'tvmaze_off' );
            if($off){
                return response()->json(['error' => 'Error 429, pleas wait a few seconds after try again'], 429, ['X-Header-One' => 'Header Value']);
            }

            if($searched != $q){
                $data = $this->getShow($q);
            }else{
                $data = Cache::get( 'tvmaze_shows' );
            }

            return response()->json($data, 200);
        }

        return response()->json(['error' => 'Unauthorized'], 401, ['X-Header-One' => 'Header Value']);
    }

    public function getShow($q){

        $response = Http::get('https://api.tvmaze.com/search/shows?q='.$q);
        $shows = $response->object();

        if($response->status() == 429){
            Cache::put('tvmaze_off', true , Carbon::now()->addSeconds(10));
        }

        //it is not possible get exact matches through the API URL, https://www.tvmaze.com/threads/4939/search-by-name-and-exact-matches
        foreach ($shows as $key => $show){
            if($show->show->name !== strtolower($q) && $show->show->name !== ucfirst($q)){
                unset($shows[$key]);
            }
        }

        $expiresAt = Carbon::now()->addMinutes(60);
        if(Cache::has('tvmaze_q') && Cache::has('tvmaze_shows')){
            Cache::flush();
        }
        Cache::put('tvmaze_q', $q , $expiresAt);
        Cache::put('tvmaze_shows', $shows , $expiresAt);

        return $shows;
    }
}
