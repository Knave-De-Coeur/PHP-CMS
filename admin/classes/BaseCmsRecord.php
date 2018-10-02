<?php
/**
 * Created by PhpStorm.
 * User: knave-de-coeur
 * Date: 02/10/18
 * Time: 13:44
 */


class BaseCmsRecord
{
    public $Id;

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
}