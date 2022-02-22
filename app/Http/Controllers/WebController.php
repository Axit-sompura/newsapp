<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use jcobhams\NewsApi\NewsApi;
use jcobhams\NewsApi\NewsApiException;

class WebController extends Controller
{
    public function index()
    {
        $country = "in";
        $sources = null;
        $category = "science";
        $q = "";
        $language = "en";
        $page_size = 5;
        $page = 0;

        $newsapi = new NewsApi('0c1992d6a2f44a4e8ababbc5c3dd7ad2');
        try {
            $top_headlines = $newsapi->getTopHeadlines($q, $sources, $country, $category, $page_size, $page);
        } catch (NewsApiException $e) {
            echo "opps! something went wrong". $e;
        }
//        print_r($top_headlines); die;

        return view('welcome', compact('top_headlines'));
    }
}
