<?php

namespace Anax\Questions;

use Anax\DatabaseActiveRecord\ActiveRecordModel;


/**
 * A database driven model using the Active Record design pattern.
 */
class Tags extends ActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "tags";



    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $tags;
    public $threadId;


    public function getTags($di)
    {

        $this->setDb($di->get("dbqb"));
        $res = $this->findAll();
        return $res;
    }



}
