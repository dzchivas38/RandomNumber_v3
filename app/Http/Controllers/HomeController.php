<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use DOMDocument;
use DateTime;
use PhpParser\Node\Expr\Cast\Object_;
use App\Models\ResultNumber;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function getNumberResultEveryDay()
    {
        $rss_tags = array(
            'title','description','pubDate','link'
        );
        $rss_item_tag = 'item';
        $rss_url = 'http://kqxs.net.vn/rss-feed/xo-so-mien-bac-xsmb-xstd.rss';
        $doc = new DOMdocument();
        try {
            $doc->load($rss_url);
            $rss_array = array();
            $items = array();
            $result_net = new ResultNumber();
            foreach($doc-> getElementsByTagName($rss_item_tag) AS $node) {
                foreach($rss_tags AS $key => $value) {
                    $items[$value] = $node->getElementsByTagName($value)->item(0)->nodeValue;
                }
                array_push($rss_array, $items);
            }
            foreach ($rss_array as $key){
                dd($key['description']);
                break;
            }
        } catch (Exception $e) {
            return $e;
        }
    }
}
