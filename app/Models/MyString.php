<?php
/**
 * Created by PhpStorm.
 * User: Dev-1
 * Date: 14/04/2018
 * Time: 06:26
 */

namespace App\Models;


class MyString
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