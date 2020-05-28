<?php

/**
 * Created by PhpStorm.
 * User: DungNV44
 * Date: 8/8/2017
 * Time: 2:46 PM
 */
namespace App\Models;
class ResultNumber
{
    private $Id;
    private $Title;
    private $description;
    private $pubDate;
    private $isDelete;

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
    public function getTitle()
    {
        return $this->Title;
    }

    /**
     * @param mixed $Title
     */
    public function setTitle($Title)
    {
        $this->Title = $Title;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getPubDate()
    {
        return $this->pubDate;
    }

    /**
     * @param mixed $pubDate
     */
    public function setPubDate($pubDate)
    {
        $this->pubDate = $pubDate;
    }

    /**
     * @return mixed
     */
    public function getisDelete()
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
    public function jsonSerialize() {
        return [
            'Id' => $this->Id,
            'Title' => $this->Title,
            'Description' => $this->description,
            'PubDate' => $this->pubDate,
            'isDelete' => $this->isDelete
        ];
    }


}