<?php

namespace Anax\Questions\HTMLForm;


use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Anax\Questions\Answer;
use Anax\Questions\Comments;
use \Anax\Vote\VoteApi;

/**
 * Form to create an item.
 */

class voteForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     */
    
    protected $formId;
    
    public function __construct(ContainerInterface $di, $email, $threadId = null, $commentId = null  ,$answerId = null)
    {
        parent::__construct($di);
        // $url = $di->get("reqeust")->getPost("VoteAction");
        $userName = $this->di->session->get("loggedin");
        $tag = "<i class='material-icons'> thumb_up</i>";
        // $this->form->addElement("<i></i>");
        
        $this->form->create(
            
            [
                "id" => __CLASS__,
                "legend" => "Vote",
            ],
            [

                "User" => [
                    "type" => "hidden", 
                    "value" => $email,
                    "name" => "email",
                ],

                "commentId" => [
                    "type" => "hidden", 
                    "value" => $commentId,
                    "name" => "commentId",
                ],

                "threadId" => [
                    "type" => "hidden", 
                    "value" => $threadId,
                    "name" => "threadId",
                ],

                "answerId" => [
                    "type" => "hidden", 
                    "value" => $answerId,
                    "name" => "answerId",
                ],
               

                "Upvote" => [
                    "id" => "upvote",
                    "type" => "submit",
                    "class" => "material-icons",
                    "value" => "thumb_up",
                    "name" =>   "vote",
                    "callback" => [$this, 'callbackSubmit'],
                ],

                "Downvote" => [
                    
                    "type" => "submit",
                    "class" => "material-icons",
                    "value" => "thumb_down",
                    "name" =>   "vote",
                    "callback" => [$this, "downCallbackSubmit"],
                ],

       

                
            ]
        );




    }



    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return bool true if okey, false if something went wrong.
     */
    public function callbackSubmit($upvote) : bool
    {
        $upvote = $this->form->value("Upvote"); 
        $this->vote($upvote);
        return true;
    }


    public function downCallbackSubmit() : bool
    {
        $downVote = $this->form->value("Downvote"); 
        $this->vote($downVote);
        return true;
    }
    
    
    public function vote($voteValue): bool 
    {
        
        $vote = new VoteApi();
        // $this->di->session->set("answerId", $this->form->value("id"));
        $vote->setDb($this->di->get("dbqb"));

        $upvoteCategory = [];
        $answerId = $this->form->value("answerId"); 
        $threadId = $this->form->value("threadId");
        $commentId = $this->form->value("commentId");
 

        // $comment = new Comment();
        // $comment->points($upvoteCategory);

        if ($commentId == null) 
        {
            #If comment id is empty it's either a Question or a answer. 
            if ($answerId == null) 
            {
                # If answer id is empty it's a thread
                $vote->questionVote($this->di, $threadId, $voteValue); 
                return true;
            }
            $vote->answerVote($this->di, $answerId, $voteValue);
            return true;
        }  
        
        $vote->commentVote($this->di, $commentId, $voteValue); 
        return true;
    }



    /**
     * Callback what to do if the form was successfully submitted, this
     * happen when the submit callback method returns true. This method
     * can/should be implemented by the subclass for a different behaviour.
     */
    // public function callbackSuccess()
    // {
    //     // $this->di->get("response")->redirect("questions/question/" . $this->questionId)->send();
    //     $this->form->addOutput("Answer.");
        
    // }



    // /**
    //  * Callback what to do if the form was unsuccessfully submitted, this
    //  * happen when the submit callback method returns false or if validation
    //  * fails. This method can/should be implemented by the subclass for a
    //  * different behaviour.
    //  */
    // public function callbackFail()
    // {
    //     // $this->di->get("response")->redirectSelf()->send();
    //     $this->form->addOutput("Answer failed.");
        
    // }
}