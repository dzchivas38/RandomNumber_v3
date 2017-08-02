<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Awjudd\FeedReader;
use App\Http\Requests;

class HomeController extends Controller
{
    public function getNumberResultEveryDay()
    {
        $res = FeedReader::read('http://kqxs.net.vn/rss-feed/xo-so-mien-bac-xsmb-xstd.rss');
        echo $res;
    }
}
