<?php

namespace App\Http\Controllers;

use App\Models\HashMap;
use App\Models\Messenger;
use App\Models\String;
use App\Models\Syntax;
use Illuminate\Http\Request;
use App\Http\Requests;
use DOMDocument;
use DateTime;
use DB;
use Psy\Util\Str;


class HomeController extends Controller
{


    public function test()
    {
        $str = "De 01.10.17.71x100n. 56.65x200n. 02.20.26.62.00x100n. de 67.76x400n. 09.90x200n. 25.52x300n. 08.80x100n. 37.73x200n. 58.85x900n. Lo 33x200n. 57.75x100n";
        $msg = new Messenger($str);
        $syntax = new Syntax();
        $syntaxList = $syntax->getAll();
        $listName = array_map(function($item) {
            return $item->Name;
        }, $syntaxList);
        $msgWithSyntax = $msg->getArrayTobeConvertFromMsg($listName);
        try {
            $results = DB::table('tbl_result_number')->whereDate('PubDate', '=', '2018-03-24')->first();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        //$temp là mảng kết quả xổ số
        $temp = preg_split('/\r\n|\r|\n/', $results->Description);
        array_shift($temp);
        //$player_join_cash_out mảng các cú pháp cùng tỉ lệ theo khách hàng
        $player_join_cash_out = DB::table('tbl_player')
            ->join('tbl_cashout', 'tbl_player.Id', '=', 'tbl_cashout.PlayerId')
            ->join('tbl_actiontype', 'tbl_cashout.ActionTypeId', '=', 'tbl_actiontype.Id')
            ->select('tbl_player.Id', 'tbl_player.Name', 'tbl_cashout.InCoin','tbl_cashout.OutCoin','tbl_actiontype.Name','tbl_actiontype.ActionTypeLevel','tbl_actiontype.Code','tbl_actiontype.Unit')
            ->where('tbl_player.Id', '=', 7)
            ->get();
        //dd($player_join_cash_out);
        $this->checkLive($msgWithSyntax,$player_join_cash_out,$temp);

    }
    public function checkLive($tin_nhan,$cash_out,$ket_qua_so_xo){
        $syn = New Syntax();
        $hm = new HashMap($cash_out);

        foreach ($tin_nhan as $key=>$value){
            $criteria = $syn->getConstSyn($key);
            $syntaxForm = $criteria->SyntaxForm;
            $x = $hm->findByKey($syntaxForm,'Code');
            $cus_cash_out = array_pop($x);
            dd($cus_cash_out);
        }
        //dd($t->SyntaxForm);
    }
    //hàm tính đoạn tin nhắn con trả về giá trị tổng.
    public function parserMsg($tin_nhan){

    }
    //Hàm tính giá trị trúng từ kết quả xổ số
    public function getReturnValue(){

    }
    public function getItem($pubDate)
    {
        try {
            $results = DB::table('tbl_result_number')->whereDate('PubDate', '=', $pubDate)->get();
            return $results;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
