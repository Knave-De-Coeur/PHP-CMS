<?php
/**
 * Created by PhpStorm.
 * User: knave-de-coeur
 * Date: 04/10/18
 * Time: 12:48
 */

require_once "BaseCmsRecord.php";

class Category extends BaseCmsRecord
{
    private $title;

    /**
     * Category constructor.
     * @param $title
     */
    public function __construct($id, $title)
    {
        $this->Id = $id;
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }


}