<?php
/**
 * Created by PhpStorm.
 * User: Dev-1
 * Date: 01/03/2018
 * Time: 21:13
 */

namespace App\Models;


class ResultCaculate
{
    private $status;
    private $msg;
    private $data;
    private $issueHightlightIndex;
    private $msg_syntax_list;

    /**
     * ResultCaculate constructor.
     */
    public function __construct()
    {
    }

    public function getMsgSyntaxList()
    {
        return $this->msg_syntax_list;
    }
    public function setMsgSyntaxList($msg_syntax_list)
    {
        $this->msg_syntax_list = $msg_syntax_list;
    }
    public function getIssueHightlightIndex()
    {
        return $this->issueHightlightIndex;
    }
    public function setIssueHightlightIndex($issueHightlightIndex)
    {
        $this->issueHightlightIndex = $issueHightlightIndex;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
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
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }
    public function jsonSerialize() {
        return [
            'status' => $this->status,
            'msg' => $this->msg,
            'data' => $this->data,
            'issueHightlightIndex' => $this->issueHightlightIndex,
            'msg_syntax_list'=>$this->msg_syntax_list
        ];
    }
}