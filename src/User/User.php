<?php

namespace Anax\User;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Anax\DatabaseActiveRecord\ActiveRecordModel;
use Anax\Questions\Answer;
use Anax\Questions\Comments;
use Anax\Questions\Questions;

/**
 * Example of FormModel implementation.
 */
class User extends ActiveRecordModel implements ContainerInjectableInterface
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
    public $bioText;

    /**
     * Set the password.
     *
     * @param string $password the password to use.
     *
     * @return void
     */
    public function setPassword($password)
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }
    /**
     * Verify the acronym and the password, if successful the object contains
     * all details from the database row.
     *
     * @param string $acronym  acronym to check.
     * @param string $password the password to use.
     *
     * @return boolean true if acronym and password matches, else false.
     */
    public function verifyPassword($email, $password)
    {
        $this->find("email", $email);
        return password_verify($password, $this->password);
    }





    // public function save() {
    //   // $this->password = password_hash($this->password, PASSWORD_DEFAULT);
    //     $this->db->connect()
    //        ->insert("User", ["email", "password"])
    //        ->execute([$this->email, $this->password])
    //        ->fetch();

    // }

    public function hasMail($email)
    {
        $this->find("email", $email);
        if ($this->email == $email) {
            return true;
        }
        return false;
    }

    public function updateUser($currentEmail)
    {
        // $this->password = password_hash($this->password, PASSWORD_DEFAULT);
         $this->setPassword($this->password);
        $password = $this->password; 
        $email = $this->email;
        $bioText = $this->bioText;
        // Not working as intended.
        $this->db->connect();
        $this->find("email", $currentEmail);

        $this->bioText = $bioText;
        $this->email = $email;
        $this->password = $password;
       
       // $this->update_attributes(array('password' => $this->password, 'id' => $this->id));
        
        $this->save();
        
    }


        public function setBio()
    {
        // $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        // Not working as intended.
        $this->db->connect()
            ->update("User", ["bioText"])
            ->execute([$this->bioText])
            ->fetch();
        
    }

    public function totalPoints($email, $di)
    {

        $answers = new Answer();
        $comments = new Comments();
        $questions = new Questions();

        $this->setDb($di->get("dbqb"));
        $this->db->connect();
        $this->findWhere("email = ?", $email);
        $this->points = 0;
        $this->save();

        $questions->setDb($di->get("dbqb"));
        $questions->db->connect();
        $data = $questions->findAllWhere("author = ?", $email);
        $this->convertToPotins($email, $data, $di);

        $comments->setDb($di->get("dbqb"));
        $comments->db->connect();
        $data = $comments->findAllWhere("author = ?", $email);
        $this->convertToPotins($email, $data, $di);

        $answers->setDb($di->get("dbqb"));
        $answers->db->connect();
        $data = $answers->findAllWhere("author = ?", $email);
        $this->convertToPotins($email, $data, $di);
        $this->findAllWhere("email = ?", $email);

        // $dataObj = (Object) $data[0];
        return $this->points;
    }

    public function convertToPotins($email, $data, $di)
    {
        $this->setDb($di->get("dbqb"));
        $this->db->connect();

        foreach ($data as $res) {
            $this->findWhere("email = ?", $email);
            $this->points += $data[0]->points;
            $this->save();
        }
    }

    public function questionAnswered($id, $di)
    {

        // $answersObj = new Answer();
        // $answersObj->setDb($di->get("dbqb"));
        // $answersObj->db->connect();
        // $answers = $answersObj->questionAnswers(0);
        $answers = new Answer();
        $answers->setDb($di->get("dbqb"));
        $answers->db->connect();
        $data = $answers->findAllWhere("questionID = ?", $id);

        if (count($data) > 0) {
            return "Answered";
        }
        return "No answer";
    }
}
