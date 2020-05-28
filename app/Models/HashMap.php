<?php
/**
 * Created by PhpStorm.
 * User: Dev-1
 * Date: 05/03/2018
 * Time: 23:50
 */
// đối tượng mảng với cấu trúc key-value
namespace App\Models;


class HashMap
{
    private $value;

    /**
     * HashMap constructor.
     * @param $value
     */
    public function __construct($value)
    {
        $this->value = (is_array($value)) ? $value : array($value);
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
    public function length(){
        return count($this->value);
    }
    /**
     * Kiểm tra chuỗi có là key của mảng
     */
    public function has($find){
        $exists = FALSE;
        if(!is_array($this->value)){
            return;
        }
        foreach ($this->value as $key => $value) {
            if($find == $value){
                $exists = TRUE;
            }
        }
        return $exists;
    }
    /**
     * Kiểm tra chuỗi có tồn tại như là key trong mảng ko phân biệt chữ hoa chữ thường
     */
    public function hasLike($find){
        $q = (string) $find;
        $exists = FALSE;
        if(!is_array($this->value)){
            return;
        }
        foreach ($this->value as $key => $value) {
            if(strtolower($q) == strtolower($value)){
                $exists = TRUE;
            }
        }
        return $exists;
    }
    public function findByKey($f,$param){
        foreach ($this->value as $key => $value){
            if ($f == $value->$param){
                return array($key=>$value);
            }
        }
    }
}