<?php

namespace Anax\Questions\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Anax\Questions\Comments;

/**
 * Form to create an item.
 */
class CreateComment extends FormModel
{
    protected $id;
    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di, $id, $answerId = "0")
    {
        parent::__construct($di);
        $userName = $this->di->session->get("loggedin");
        $this->id = $id;
        // $id = $this->di->session->get("id");
        // $answerId = $this->di->session->get("answerId");
        $this->form->create(
            [
                "id" => "commentSubmit",
            ],
            [
                "author" => [
                    "type" => "hidden",
                    "value" => $userName,
                    "validation" => ["not_empty"],
                ],

                "comment" => [
                    "type" => "textarea",
                    "validation" => ["not_empty"],
                ],

                "threadId" => [
                    "type" => "hidden",
                    "value" => $id,
                ],

                "answerId" => [
                    "type" => "hidden",
                    "value" => $answerId,
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Comment",
                    "callback" => [$this, "callbackSubmit"]
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
    public function callbackSubmit() : bool
    {
        $comments = new Comments();
        $comments->setDb($this->di->get("dbqb"));
        $comments->author = $this->form->value("author");
        $comments->comment = $this->form->value("comment");
        $comments->answerId = $this->form->value("answerId");
        $comments->threadId = $this->form->value("threadId");
        $comments->save();
        return true;
    }



    /**
     * Callback what to do if the form was successfully submitted, this
     * happen when the submit callback method returns true. This method
     * can/should be implemented by the subclass for a different behaviour.
     */
    public function callbackSuccess()
    {

        $this->di->get("response")->redirect("question/". $this->id)->send();
    }



    // /**
    //  * Callback what to do if the form was unsuccessfully submitted, this
    //  * happen when the submit callback method returns false or if validation
    //  * fails. This method can/should be implemented by the subclass for a
    //  * different behaviour.
    //  */
    // public function callbackFail()
    // {
    //     $this->di->get("response")->redirectSelf()->send();
    // }
}
