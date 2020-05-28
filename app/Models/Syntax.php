<?php
/**
 * Created by PhpStorm.
 * User: dungnv31
 * Date: 11/10/2017
 * Time: 10:41 AM
 */

namespace App\Models;
use DB;

class Syntax
{
    private $Id;
    private $Name;
    private $ActionTypeId;
    private $Description;
    private $SyntaxForm;

    /**
     * Syntax constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->Id;
    }

    /**
     * @param mixed $Id
     */
    public function setId($Id)
    {
        $this->Id = $Id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->Name;
    }

    /**
     * @param mixed $Name
     */
    public function setName($Name)
    {
        $this->Name = $Name;
    }

    /**
     * @return mixed
     */
    public function getActionTypeId()
    {
        return $this->ActionTypeId;
    }

    /**
     * @param mixed $ActionTypeId
     */
    public function setActionTypeId($ActionTypeId)
    {
        $this->ActionTypeId = $ActionTypeId;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->Description;
    }

    /**
     * @param mixed $Description
     */
    public function setDescription($Description)
    {
        $this->Description = $Description;
    }

    /**
     * @return mixed
     */
    public function getSyntaxForm()
    {
        return $this->SyntaxForm;
    }

    /**
     * @param mixed $SyntaxForm
     */
    public function setSyntaxForm($SyntaxForm)
    {
        $this->SyntaxForm = $SyntaxForm;
    }

    public function jsonSerialize() {
        return [
            'Id' => $this->Id,
            'Name' => $this->Name,
            'ActionTypeId' => $this->ActionTypeId,
            'Description' => $this->Description,
            'SyntaxForm' => $this->SyntaxForm
        ];
    }
    public function getAll(){
        try {
            $results = DB::table('tbl_syntax')->get();
            return $results;
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function getConstSyn($str){
        try {
            $results = DB::table('tbl_syntax')->where('Name','=',$str)->first();
            return $results;
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}