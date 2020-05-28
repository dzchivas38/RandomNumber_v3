<?php
/**
 * Created by PhpStorm.
 * User: Dev-1
 * Date: 11/03/2018
 * Time: 15:31
 */
// Đối tượng tin nhắn truyền vào để kiểm tra và tính toán
namespace App\Models;


class Messenger
{
    private $value = "";
    private $arrIndex = array();
    private $mang_tach_chuoi = array();
    private $arrTemp = array();
    private $key = "";
    private $syntax_list = array();

    public function getSyntaxList()
    {
        return $this->syntax_list;
    }
    public function setSyntaxList($syntax_list)
    {
        $this->syntax_list = $syntax_list;
    }
    /**
     * Messenger constructor.
     * @param string $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * Hàm đệ quy tách chuỗi theo mảng cú pháp thành hashmap với key là cú pháp
     */
    private function convertMsgToArrayWithSyntax($str){
        $str = (is_string($str)) ? $str : "";
        $str = trim($str);// ko xóa đoạn code này

        $map = new HashMap($this->syntax_list);
        if ($map->length() == 0){
            return 0;
        }
        if (strlen($str) == 0) {
            return 0;
        } else {
            $clone_msg = new MyString($str);
            $first = $clone_msg->firstIndexOf(' ');
            $strCheck = (string) $clone_msg->subString($first); // String cắt A ; string còn lại B là str1->get
            $checked = $map->hasLike($strCheck);
            //Nếu đoạn string sau space đầu tiên có trong mảng cú pháp
            if ($checked) {//A thuộc mảng cú pháp
                if (count($this->mang_tach_chuoi) > 0) {
                    $this->arrTemp = $this->mang_tach_chuoi;
                    //lấy phần tử cuối cùng của mảng tách chuỗi
                    $tail = array_pop($this->mang_tach_chuoi);
                    while ($string_name = current($this->arrTemp)) {
                        if ($string_name == $tail) {
                            $this->key = key($this->arrTemp);
                        }
                        next($this->arrTemp);
                    }
                    //Tim indexA trong tail
                    $indexACheck = new MyString($tail);
                    $offsetIndexA = $indexACheck->firstIndexOf($strCheck);
                    $newValue = $indexACheck->subString($offsetIndexA);
                    $this->mang_tach_chuoi = array_merge($this->mang_tach_chuoi,array($this->key=>$newValue));
                    $subSyntax = new MyString($indexACheck->get());
                    $subSyntax->subString(strlen($strCheck));
                    $this->mang_tach_chuoi = array_merge($this->mang_tach_chuoi,array($strCheck=>$subSyntax->get()));
                    $this->convertMsgToArrayWithSyntax($subSyntax->get());

                } else {
                    $this->mang_tach_chuoi = array($strCheck => $clone_msg->get());
                    $this->convertMsgToArrayWithSyntax($clone_msg->get());
                }

            } else {
                if ($clone_msg->get() !== str_replace(' ', '', $clone_msg->get())) {
                    //Have whitespace
                    $this->convertMsgToArrayWithSyntax($clone_msg->get());
                } else {
                    //không có khoảng trắng
                    return 0;
                }
            }
        }
    }
    /**
     * @return array
     * Trả về mảng với key là cú pháp và value là đoạn string của tin nhắn
     */
    public function getArrayTobeConvertFromMsg($array)
    {
        $array = (is_array($array)) ? $array: array();
        $this->setSyntaxList($array);
        $this->convertMsgToArrayWithSyntax($this->value);
        return $this->mang_tach_chuoi;
    }
}