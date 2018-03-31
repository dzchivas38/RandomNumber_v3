<?php
/**
 * Created by PhpStorm.
 * User: Dev-1
 * Date: 01/03/2018
 * Time: 21:34
 */

namespace App\Models;

//Đối tượng chuỗi và các hàm xử lý chuỗi
class String
{
    private $value;
    /**
     * String constructor.
     * @param $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @return giá trị chuỗi string được khởi tạo
     */
    public function get()
    {
        return $this->value;
    }
    private function set($value){
        $this->value = $value;
    }
    public function length(){
        return strlen($this->value);
    }
    public function trimS(){
        $this->value = trim($this->value);
    }
    public function getIndexOf($needle,$offset){
        return strpos($this->value, $needle,intval($offset));
    }
    public function firstIndexOf($needle){
        return strpos($this->value, $needle,0);
    }
    public function subString($offset){
        $return = substr($this->value,0,$offset);
        $tmp = substr($this->value,$offset,$this->length() - $offset);
        $this->set($tmp);
        return $return;
    }
    public function explode($needle){
        return explode($needle,$this->value);
    }
}