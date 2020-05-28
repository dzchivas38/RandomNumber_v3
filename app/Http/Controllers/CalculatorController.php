<?php

namespace App\Http\Controllers;

use App\Models\ActionType;
use App\Models\Messenger;
use App\Models\MyString;
use App\Models\ResultCaculate;
use App\Models\ResultViewModel;
use App\Models\Syntax;
use Illuminate\Http\Request;
use Illuminate\Support\collection;
use App\Models\HashMap;

use App\Http\Requests;
use DateTime;
use DB;
use Psy\Util\Str;
class CalculatorController extends Controller
{
    private $msg_syntax_list = array();
    /**
     * Display a listing of the resource.
     * @param $rq
     * @return \Illuminate\Http\Response
     */
    //public function index($strMsg, $pubDate, $customer)
    public function index(Request $rq)
    {
        $strMsg = $rq->input('msg');
        $dt_pub_date = $rq->input('pubDate');
        $player = $rq->input('player');
        //-------------------------------
        $syntax = new Syntax();
        $result = new ResultCaculate();
        $syntaxList = $syntax->getAll();
        $listName = array_map(function($item) {
            return $item->Name;
        }, $syntaxList);
        $syntaxIssueList = $this->validateSyntax($strMsg,$listName);
        if (count($syntaxIssueList) > 0){
            //Tồn tại chuỗi kí tự trong đoạn tin nhắn không có trong danh sách cú pháp
            $result->setIssueHightlightIndex($syntaxIssueList);
            $result->setStatus(false);
            $result->setMsg("Cú pháp tin nhắn chưa đúng !");
            $result->setData(null);
            $result->setMsgSyntaxList($this->msg_syntax_list);
        }else{
            //Tin nhắn sử dụng để tính toán đúng cú pháp
            $data = $this->process($strMsg,$dt_pub_date,$player,$listName);
            if ($data == false){
                $result->setStatus(false);
                $result->setIssueHightlightIndex($syntaxIssueList);
                $result->setMsg("Không có kết quả");
                $result->setMsgSyntaxList($this->msg_syntax_list);
                $result->setData(0);
            }else{
                $result->setIssueHightlightIndex($syntaxIssueList);
                $result->setStatus(true);
                $result->setMsg("Cú pháp tin nhắn chính xác !");
                $result->setMsgSyntaxList($this->msg_syntax_list);
                $result->setData($data);
            }
        }
        return $result->jsonSerialize();
    }
    /**
     * Hàm kiểm tra tính hợp lệ củ tin nhập vào
     * @param $strMsg: đoạn tin nhắn cần kiểm tra cú pháp
     * @param $syntaxList: mảng cú pháp sử dụng để tính toán
     * @return array
    */
    public function validateSyntax($strMsg, $syntaxList){
        $errorList = array();
        $strMsg = (is_string($strMsg)) ? $strMsg : "";
        $msg = new Messenger($strMsg);
        $msgWithSyntax = $msg->getArrayTobeConvertFromMsg($syntaxList);
        $this->msg_syntax_list = $msgWithSyntax;
        foreach ($msgWithSyntax as $item) {
            $value = $this->syntaxChildValidate($item);
            if (count($value) > 0){
                $errorList = array_merge($errorList,$value);
            }
        }
        return $errorList;
    }
    /**
     * Hàm tính toán khi chuỗi nhập vào là đúng cú pháp
     * trả về mảng string có cú pháp ko có kí tự X hoặc x
     */
    public function process($strMsg,$dt_pub_date,$player,$syntaxList){
        try{
            $msg = new Messenger($strMsg);
            $msgWithSyntax = $msg->getArrayTobeConvertFromMsg($syntaxList);
            //lay ket qua soxo theo ngay post len
            try {
                $results = DB::table('tbl_result_number')->whereDate('PubDate', '=', $dt_pub_date)->first();
                if (!$results){
                    return false;
                }
                $xs_live = preg_split('/\r\n|\r|\n/', $results->Description);
                array_shift($xs_live);
            } catch (\Exception $e) {
                return $e->getMessage();
            }
            //$temp là mảng kết quả xổ số
            $temp = preg_split('/\r\n|\r|\n/', $results->Description);
            array_shift($temp);
            //$player_join_cash_out mảng các cú pháp cùng tỉ lệ theo khách hàng
            try{
                $player_join_cash_out = DB::table('tbl_player')
                    ->join('tbl_cashout', 'tbl_player.Id', '=', 'tbl_cashout.PlayerId')
                    ->join('tbl_actiontype', 'tbl_cashout.ActionTypeId', '=', 'tbl_actiontype.Id')
                    ->select('tbl_player.Id', 'tbl_player.Name',
                        'tbl_cashout.InCoin','tbl_cashout.OutCoin','tbl_actiontype.Name',
                        'tbl_actiontype.ActionTypeLevel','tbl_actiontype.Code','tbl_actiontype.Unit',
                        'tbl_actiontype.IsFirstChirld')
                    ->where('tbl_player.Id', '=', $player['Id'])
                    ->get();
            }catch (\Exception $e) {
                return $e->getMessage();
            }
            $return_data = $this->checkLive($msgWithSyntax,$player_join_cash_out,$temp);
        }catch (\ErrorException $ex){
            return $ex;
        }
        return $return_data;
    }
    public function checkLive($tin_nhan,$cash_out,$ket_qua_so_xo){
        $syn = New Syntax();
        $hm = new HashMap($cash_out);
        $vm_result_list = array();
        $kq_list = array_map(function($key,$value) {
            $value = trim($value);
            $i = strpos($value, " ",0);
            $v = substr($value,$i,strlen($value) - $i);
            $v = trim($v);
            if ($key == 0){
                return $v;
            }else{
                $v = explode(" - ",$v);
                return $v;
            }
        }, array_keys($ket_qua_so_xo),array_values($ket_qua_so_xo));
        foreach ($tin_nhan as $key=>$value){
            $criteria = $syn->getConstSyn($key);
            $syntaxForm = $criteria->SyntaxForm;
            $x = $hm->findByKey($syntaxForm,'Code');
            $cus_cash_out = array_pop($x);
            $vm_result = $this->parserMsg($value,$cus_cash_out,$kq_list);
            $vm_result_list = array_merge($vm_result_list,$vm_result);
        }
        return $vm_result_list;
    }
    //hàm tính đoạn tin nhắn con trả mảng kết quả.
    public function parserMsg($tin_nhan,$cash_out,$ket_qua_so_xo){
        $return_list = array();
        $tin_nhan =  new MyString($tin_nhan);
        $tin_nhan->trimS();
        $point_group = $tin_nhan->explode(" ");
        if(count($point_group) > 0){
            foreach ($point_group as $key=>$value){
                $str = new MyString($value);
                $obj_result_vm = new ResultViewModel($value);
                $index = $str->firstIndexOf("x");
                $point_vali = $str->subString($index);
                $num_list = explode(".",$point_vali);

                //chuyển chuỗi string thành mảng
                $char_list_money = str_split($str->get());
                $n = $this->getFirstIndexOfNumber($char_list_money);
                $c = $this->getFirstIndexOfChar($char_list_money,$n);
                if ($c === null){
                    $c = $str->length();
                }
                $vali = substr($str->get(),$n,$c-$n);//giá trị của các số dánh
                //check có phải là lô xiên hay ko
                if ($cash_out->IsFirstChirld == 1 && $cash_out->ActionTypeLevel > 1){
                    $sum = $vali*($cash_out->InCoin);
                }else{
                    $sum = count($num_list); //đếm số đánh qua dấu . nên + 1 do ko có dấu . cuối
                    $sum = $sum*$vali*($cash_out->InCoin);
                }
                // Đoạn so kết quả với từng loại chơi check ở đây
                if ($cash_out->IsFirstChirld == 0){//bằng 0 tức là đề
                    switch ($cash_out->ActionTypeLevel)
                    {
                        case 0 :
                            $bingo_list = $this->getResultFormRList($num_list,$ket_qua_so_xo,2,2,false,0,0);
                            break;
                        default:
                            echo "Không tìm thấy";
                            break;
                    }

                }else{ //lô
                    switch ($cash_out->ActionTypeLevel)
                    {
                        case 1 : // lô thường
                            $bingo_list = $this->getResultFormRList($num_list,$ket_qua_so_xo,2,2,true,null,0);
                            break;
                        case 2 : // xiên 2
                            $bingo_list = $this->getResultFormRList($num_list,$ket_qua_so_xo,2,2,true,null,2);
                            break;
                        case 3 : // xiên 3
                            $bingo_list = $this->getResultFormRList($num_list,$ket_qua_so_xo,2,2,true,null,3);
                            break;
                        case 4 : // xiên 3
                            $bingo_list = $this->getResultFormRList($num_list,$ket_qua_so_xo,2,2,true,null,4);
                            break;
                        default:
                            echo "Không tìm thấy";
                            break;
                    }
                }

                $bingo_count = count($bingo_list);
                if ($bingo_count >0){
                    $bingo_val = $bingo_count*$vali*($cash_out->OutCoin);
                }else{
                    $bingo_val = 0;
                }
                $kq_cc = $bingo_val - $sum;
                $obj_result_vm->setSum($sum);
                $obj_result_vm->setSoTrung($bingo_list);
                $obj_result_vm->setBingo($bingo_val);
                $obj_result_vm->setKqCc($kq_cc);
                $obj_result_vm->setActionType($cash_out->Code);
                $obj_result_vm->setSoDanh($num_list);
                $obj_result_vm->setValue($vali);
                $obj_result_vm->setActionTypeName($cash_out->Name);
                $return_list[] = $obj_result_vm->jsonSerialize();
            }
        }
        return $return_list;
    }
    //hàm tìm số trong mảng kết quả dạng arr(arr) trả về mảng những số có trong danh sách
    //r_list là mảng kết quả xổ số đã gia công
    //$check_point : vị trí check tính từ cuối số check, bắt đầu từ 1, vd đề 2 số cuối thì check_point là 2
    //$offset là độ dài số cần check
    //xien_may là số lượng số cần check ví dụ xien2 là check 2 số
    private function getResultFormRList($num_list,$r_list,$check_point,$offset,$check_all,$vi_tri_check,$xien_may){
        $re_list = array();
        if ($check_all){
            foreach ($num_list as $num){
                foreach ($r_list as $result){
                    if (is_array($result)){
                        foreach ($result as $r){
                            $d = substr($r,strlen($r) - $check_point,$offset);
                            if ($num == $d){
                                $re_list[] = $num;
                            }
                        }
                    }else{
                        $d = substr($result,strlen($result) - $check_point,$offset);
                        if ($num == $d){
                            $re_list[] = $num;
                        }
                    }
                }
            }
        }else{
            $item = "";
            if (!is_array($r_list[$vi_tri_check])){
                $res = $r_list[$vi_tri_check];
                $item = substr($res,strlen($res) - $check_point,$offset);
            }
            foreach ($num_list as $num){
                if (is_array($r_list[$vi_tri_check])){
                    $res = $r_list[$vi_tri_check];
                    foreach ($res as $r){
                        $d = substr($r,strlen($r) - $check_point,$offset);
                        if ($num == $d){
                            $re_list[] = $num;
                        }
                    }
                }else{
                    if ($num == $item){
                        $re_list[] = $num;
                    }
                }
            }
            if ($xien_may > 0){
                if (count($re_list) >= $xien_may){
                    return $re_list;
                }else{
                    $n = array();
                    return $n;
                }
            }else{
                return $re_list;
            }
        }
        return $re_list;
    }

    //hàm lấy vị trị giá trị đầu tiên là số
    private function getFirstIndexOfNumber($arr){
        if (is_array($arr)){
            foreach ($arr as $key=>$value){
                if (ctype_digit($value)){
                    return $key;
                }
            }
        }else{
            return -1;
        }
    }
    //hàm lấy vị trị giá trị đầu tiên là chữ
    private function getFirstIndexOfChar($arr,$index_num){
        if (is_array($arr)){
            foreach ($arr as $key=>$value){
                if (!ctype_digit($value) && $key > $index_num){
                    return $key;
                }
            }
        }else{
            return -1;
        }
    }
    /**
     * Hàm kiểm tra lỗi sai trong toạn tin nhắn đã nhóm theo cú pháp
     * Ví dụ "De" => " 01.10.17.71x100n. 56.65x200n. 02.20.26.62.00x100n. "
     * @param $syntaxChild là đoạn tin nhắn trong nhóm 1 cú pháp kiểu chơi ví dụ như đề
     * @return array
     */
    public function syntaxChildValidate($syntaxChild){
        $errorList = array();
        $syntaxChild = is_string($syntaxChild) ? trim($syntaxChild) : "";
        $syntaxChild = new MyString($syntaxChild);
        if ($syntaxChild->length() > 0){
            $syntaxChildList = explode(" ",$syntaxChild->get());
            foreach ($syntaxChildList as $item) {
                $d = (strpos($item, 'x'));
                if(substr_count($item,"x") >=2){
                    $errorList[] = $item;
                }else{
                    if (!$d){
                        $errorList[] = $item;
                    }else{
                        $item_clone = new MyString($item);
                        $x_index = $item_clone->firstIndexOf("x");
                        $x_sub = $item_clone->subString($x_index);
                        $number_only = preg_replace("/[^0-9]/", "", $item_clone->get());
                        if (strlen($number_only) >5){
                            $errorList[] = $item;
                        }
                    }
                }
            }
        }else{

        }
        return $errorList;
    }
}
