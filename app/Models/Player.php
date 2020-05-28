<?php
/**
 * Created by PhpStorm.
 * User: dungnv31
 * Date: 11/10/2017
 * Time: 9:55 AM
 */

namespace App\Models;


class Player
{
    private $Id;
    private $Name;
    private $PhoneNumber;
    private $PlayerTypeId;
    private $isDelete;
    private $Description;

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
    public function getPhoneNumber()
    {
        return $this->PhoneNumber;
    }

    /**
     * @param mixed $PhoneNumber
     */
    public function setPhoneNumber($PhoneNumber)
    {
        $this->PhoneNumber = $PhoneNumber;
    }

    /**
     * @return mixed
     */
    public function getPlayerTypeId()
    {
        return $this->PlayerTypeId;
    }

    /**
     * @param mixed $PlayerTypeId
     */
    public function setPlayerTypeId($PlayerTypeId)
    {
        $this->PlayerTypeId = $PlayerTypeId;
    }

    /**
     * @return mixed
     */
    public function getIsDelete()
    {
        return $this->isDelete;
    }

    /**
     * @param mixed $isDelete
     */
    public function setIsDelete($isDelete)
    {
        $this->isDelete = $isDelete;
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
    public function jsonSerialize() {
        return [
            'Id' => $this->Id,
            'Name' => $this->Name,
            'PhoneNumber' => $this->PhoneNumber,
            'PlayerTypeId' => $this->PlayerTypeId,
            'isDelete' => $this->isDelete,
            'Description' => $this->Description
        ];
    }
}