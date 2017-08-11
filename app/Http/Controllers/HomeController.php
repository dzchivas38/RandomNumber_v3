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
            'title','description','pubDate'
        );
        $rss_item_tag = 'item';
        $rss_url = 'http://kqxs.net.vn/rss-feed/xo-so-mien-bac-xsmb-xstd.rss';
        $doc = new DOMdocument();
        $doc->load($rss_url);
        $rss_array = array();
        $items = array();
        $result_net = new ResultNumber();
        $born = Carbon::createFromDate(1987, 4, 23);
        $noCake = Carbon::createFromDate(2014, 9, 26);
        var_dump($born->isBirthday($noCake));
        foreach($doc-> getElementsByTagName($rss_item_tag) AS $node) {
            foreach($rss_tags AS $key => $value) {
                $items[$value] = $node->getElementsByTagName($value)->item(0)->nodeValue;
            }
            array_push($rss_array, $items);
        }
//        foreach ($rss_array as $key){
//            var_dump($key['pubDate']);
//            break;
//        }
//        $test = new DateTime("Tue, 08 Aug 2017 14:50:50 GMT",null);
//        return json_encode($test);
        //dd($rss_array);
        //return $rss_array;
    }
}
