<?php
/**
 * Created by PhpStorm.
 * User: dungnv31
 * Date: 11/10/2017
 * Time: 10:31 AM
 */

namespace App\Models;
use DB;

class ActionType
{
    private $Id;
    private $Name;
    private $ActionTypeLevel;
    private $IsFirstChirld;
    private $Description;
    private $Code;
    private $Unit;

    /**
     * ActionType constructor.
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
    public function getActionTypeLevel()
    {
        return $this->ActionTypeLevel;
    }

    /**
     * @param mixed $ActionTypeLevel
     */
    public function setActionTypeLevel($ActionTypeLevel)
    {
        $this->ActionTypeLevel = $ActionTypeLevel;
    }
    /**
     * @return mixed
     */
    public function getIsFirstChirld()
    {
        return $this->IsFirstChirld;
    }

    /**
     * @param mixed $IsFirstChirld
     */
    public function setIsFirstChirld($IsFirstChirld)
    {
        $this->IsFirstChirld = $IsFirstChirld;
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
    public function getCode()
    {
        return $this->Code;
    }

    /**
     * @param mixed $Code
     */
    public function setCode($Code)
    {
        $this->Code = $Code;
    }

    /**
     * @return mixed
     */
    public function getUnit()
    {
        return $this->Unit;
    }

    /**
     * @param mixed $Unit
     */
    public function setUnit($Unit)
    {
        $this->Unit = $Unit;
    }

    public function jsonSerialize() {
        return [
            'Id' => $this->Id,
            'Name' => $this->Name,
            'ActionTypeLevel' => $this->ActionTypeLevel,
            'IsFirstChirld' => $this->IsFirstChirld,
            'Description' => $this->Description,
            'Code' => $this->Code,
            'Unit' => $this->Unit
        ];
    }
    public function getAll(){
        try {
            $results = DB::table('tbl_actiontype')->get();
            return $results;
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}