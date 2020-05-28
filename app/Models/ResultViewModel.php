<?php
/**
 * Created by PhpStorm.
 * User: Dev-1
 * Date: 01/04/2018
 * Time: 13:37
 */

namespace App\Models;


class ResultViewModel
{
    private $msg;
    private $sum;
    private $bingo;
    private $so_danh;
    private $so_trung;
    private $kq_cc;
    private $action_type;
    private $action_type_name;
    private $value;
    /**
     * ResultViewModel constructor.
     * @param $msg
     */
    public function __construct($msg)
    {
        $this->msg = $msg;
    }

    /**
     * @return mixed
     */
    public function getMsg()
    {
        return $this->msg;
    }

    /**
     * @param mixed $msg
     */
    public function setMsg($msg)
    {
        $this->msg = $msg;
    }

    /**
     * @return mixed
     */
    public function getSum()
    {
        return $this->sum;
    }

    /**
     * @param mixed $sum
     */
    public function setSum($sum)
    {
        $this->sum = $sum;
    }

    /**
     * @return mixed
     */
    public function getBingo()
    {
        return $this->bingo;
    }

    /**
     * @param mixed $bingo
     */
    public function setBingo($bingo)
    {
        $this->bingo = $bingo;
    }

    /**
     * @return mixed
     */
    public function getSoDanh()
    {
        return $this->so_danh;
    }

    /**
     * @param mixed $so_danh
     */
    public function setSoDanh($so_danh)
    {
        $this->so_danh = $so_danh;
    }

    /**
     * @return mixed
     */
    public function getSoTrung()
    {
        return $this->so_trung;
    }

    /**
     * @param mixed $so_trung
     */
    public function setSoTrung($so_trung)
    {
        $this->so_trung = $so_trung;
    }

    /**
     * @return mixed
     */
    public function getKqCc()
    {
        return $this->kq_cc;
    }

    /**
     * @param mixed $kq_cc
     */
    public function setKqCc($kq_cc)
    {
        $this->kq_cc = $kq_cc;
    }

    /**
     * @return mixed
     */
    public function getActionType()
    {
        return $this->action_type;
    }

    /**
     * @param mixed $action_type
     */
    public function setActionType($action_type)
    {
        $this->action_type = $action_type;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getActionTypeName()
    {
        return $this->action_type_name;
    }

    /**
     * @param mixed $action_type_name
     */
    public function setActionTypeName($action_type_name)
    {
        $this->action_type_name = $action_type_name;
    }

    public function jsonSerialize() {
        return [
            'msg' => $this->msg,
            'sum' => $this->sum,
            'bingo' => $this->bingo,
            'so_danh' => $this->so_danh,
            'so_trung' => $this->so_trung,
            'kq_cc' => $this->kq_cc,
            'action_type'=>$this->action_type,
            'value'=>$this->value,
            'action_type_name'=>$this->action_type_name
        ];
    }
}