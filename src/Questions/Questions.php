<?php

namespace Anax\Questions;

use Anax\DatabaseActiveRecord\ActiveRecordModel;
use Anax\Questions\Answer;
use Anax\Questions\Comments;
use Anax\Questions\HTMLForm\CreateComment;
use Anax\Questions\Tags;

/**
 * A database driven model using the Active Record design pattern.
 */
class Questions extends ActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "questions";

    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $id;
    public $title;
    public $author;
    public $text;
    public $points;

    public function indexFind($tag = null, $di = null)
    {
        $tagListArray = [];
        $tagsClass = new Tags();
        $tagsClass->setDb($di->get("dbqb"));
        $this->setDb($di->get("dbqb"));
        // $res = $this->findAllWhere("tags = ?", ["java"]);
        if ($tag !== null) {
            // $tagListArray = $tagsClass->findAllWhere("tags = ?", [$tag]);
            $tagListArray = $this->findAllWhere("tags LIKE ?", ["%" . $tag . "%"]);
        } else {
            // $tagListArray = $tagsClass->findAll();
            $tagListArray = $this->findAll();
        }

        // foreach ($tagListArray as $value) {
        //   $value->threadId;
        // }
        // $res = $this->findAll();
        return $tagListArray;
    }

    public function userInfo($id = null, $di = null)
    {
        $this->setDb($di->get("dbqb"));
        $res = $this->findAllWhere("id = ?", $id);
        return $res;
    }

    public function comments($id = null, $di = null)
    {
        $comments = new Comments();
        $res = $comments->questionComments($id, $di);
        return $res;
    }

    public function answers($id = null, $di = null)
    {
        $comments = new Answer();
        $res = $comments->questionAnswers($id, $di);
        return $res;
    }

    public function answersForms($answers, $di, $id)
    {
        $res = [];
        foreach ($answers as $value) {
            $commentForm = new CreateComment($di, $id, $value->id);
            array_push($res, $commentForm->getHTML());
        }

        return $res;
    }

    public function indexUser($username = null, $di = null)
    {
        $questionListArray = [];
        $questionClass = new Questions();
        $questionClass->setDb($di->get("dbqb"));
        // $questions = [];

        $this->setDb($di->get("dbqb"));
        $questionListArray = $this->findAllWhere("author = ?", [$username]);

        return $questionListArray;
    }

    public function indexUserComments($username = null, $di = null)
    {
        $commentListArray = [];
        $commentClass = new Comments();
        $commentClass->setDb($di->get("dbqb"));
        // $comments = [];

        $this->setDb($di->get("dbqb"));
        $commentListArray = $commentClass->findAllWhere("author = ?", [$username]);

        return $commentListArray;
    }
}
