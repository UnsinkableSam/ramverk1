<?php

namespace Anax\Questions;

use Anax\DatabaseActiveRecord\ActiveRecordModel;

/**
 * A database driven model using the Active Record design pattern.
 */
class Comments extends ActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "comments";



    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $id;
    public $author;
    public $comment;
    public $points;


    public function userInfo($id = null, $di)
    {

        $this->setDb($di->get("dbqb"));
        $res = $this->findAll();

        // if (!$res) {
        //    $res = "Not logged in as a user";
        // }
        return $res;
    }


    public function points($id = null, $di)
    {

        $this->setDb($di->get("dbqb"));
        $res = $this->findAllWhere("id = ?", $id);
        $this->points += 1;
        // if (!$res) {
        //    $res = "Not logged in as a user";
        // }
        return $res;
    }



    public function questionComments($id = null, $di)
    {

        $this->setDb($di->get("dbqb"));
        $res = $this->findAllWhere("threadId = ?", $id);

        // if (!$res) {
        //    $res = "Not logged in as a user";
        // }
        return $res;
    }

    public function answerComments($id = null, $di)
    {

        $this->setDb($di->get("dbqb"));
        $res = $this->findAllWhere("answerId = ? threadId = ?", "13 1");

        // if (!$res) {
        //    $res = "Not logged in as a user";
        // }
        return $res;
    }



    public function userComments($username = null, $di)
    {

        $this->setDb($di->get("dbqb"));
        $res = $this->findAllWhere("author = ?", $username);

        // if (!$res) {
        //    $res = "Not logged in as a user";
        // }
        return $res;
    }




}