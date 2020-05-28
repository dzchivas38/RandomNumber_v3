<?php

namespace App\Console\Commands;

use Faker\Provider\DateTime;
use Illuminate\Console\Command;
use DOMDocument;
use DB;
use App\Models\ResultNumber;

class getResultNumberScheduce extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:getResultNumber';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Job lay ket qua xo so hang ngày';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
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
                $result_net->setTitle($key['title']);
                $result_net->setDescription($key['description']);
                $now = new \DateTime();
                $result_net->setPubDate($now->format('Y-m-d-H-i-s'));
                $result_net->setIsDelete(false);
                break;
            }
            DB::table('tbl_result_number')->insert($result_net->jsonSerialize());
        } catch (Exception $e) {
            return $e;
        }

    }
}
