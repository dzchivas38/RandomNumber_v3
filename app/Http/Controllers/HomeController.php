<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Awjudd\FeedReader;
use App\Http\Requests;
use DOMDocument;
class HomeController extends Controller
{
    public function getNumberResultEveryDay()
    {
        $rss_tags = array(
            'title','description','pubDate'
        );
        $rss_item_tag = 'item';
        $rss_url = 'http://kqxs.net.vn/rss-feed/xo-so-mien-bac-xsmb-xstd.rss';
        $doc = new DOMdocument();
        $doc->load($rss_url);
        $rss_array = array();
        $items = array();
        foreach($doc-> getElementsByTagName($rss_item_tag) AS $node) {
            foreach($rss_tags AS $key => $value) {
                $items[$value] = $node->getElementsByTagName($value)->item(0)->nodeValue;
            }
            array_push($rss_array, $items);
        }
        //dd($rss_array);
        return $rss_array;
    }
}
