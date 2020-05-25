<?php 

namespace Anax\Vote;


use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Psr\Container\ContainerInterface;
use Anax\DatabaseActiveRecord\ActiveRecordModel;
use Anax\Questions\Answer;
use Anax\Questions\Comments;
use Anax\Questions\Questions;




class VoteApi extends ActiveRecordModel implements ContainerInjectableInterface
{  
    use ContainerInjectableTrait;


     /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "User";

    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $id;
    public $email;
    public $password;
    public $created;
    public $updated;
    public $deleted;
    public $active;
    public $points;

    
    public function hello($di)
    {   
        $this->setDb($di->get("dbqb"));
        $this->db->connect();
        $this->findWhere("id == ?", 4);
        $this->id -= 1;
        echo $this->id;
    }


    public function DownVote($di, $email, $vote) {
        $this->setDb($di->get("dbqb"));
        $this->db->connect();
        $this->findWhere("email == ?", $email);
        if ($vote == "thumb_up") {
            $this->points += 1;
        } else {
            $this->points -= 1;
        } 
        echo $this->points;
        $this->save();
        return "saved";

        
      }

      public function commentVote($di, $commentId, $vote) 
      {
        
        $comment = new Comments();
        $comment->setDb($di->get("dbqb"));
        $comment->db->connect();
        $comment->findWhere("id = ?", $commentId);
        if ($vote == "thumb_up") {
            $comment->points += 1;
        } else {
            $comment->points -= 1;
        } 
        $comment->save();
        return "saved";

      }

      public function answerVote($di, $answerId, $vote) 
      {
        
        $answer = new Answer();
        $answer->setDb($di->get("dbqb"));
        $answer->db->connect();
        $answer->findWhere("id == ?", $answerId);
        if ($vote == "thumb_up") {
            $answer->points += 1;
        } else {
            $answer->points -= 1;
        } 
        $answer->save();
        return "saved";

      }


      public function questionVote($di, $questionId, $vote) 
      {
        
        $question = new Questions();
        $question->setDb($di->get("dbqb"));
        $question->db->connect();
        $question->findWhere("id == ?", $questionId);
        if ($vote == "thumb_up") {
            $question->points += 1;
        } else {
            $question->points -= 1;
        } 
        $question->save();
        return "saved";

      }
}