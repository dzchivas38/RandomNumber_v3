<?php
/**
 * Created by PhpStorm.
 * User: dungnv31
 * Date: 11/10/2017
 * Time: 10:18 AM
 */

namespace App\Models;


class PlayerType
{
    private $Id;
    private $Name;
    private $RuleAction;
    private $Description;

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
    public function getRuleAction()
    {
        return $this->RuleAction;
    }

    /**
     * @param mixed $RuleAction
     */
    public function setRuleAction($RuleAction)
    {
        $this->RuleAction = $RuleAction;
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
     * PlayerType constructor.
     */
    public function __construct()
    {
    }
    public function jsonSerialize() {
        return [
            'Id' => $this->Id,
            'Name' => $this->Name,
            'RuleAction' => $this->RuleAction,
            'Description' => $this->Description
        ];
    }
}