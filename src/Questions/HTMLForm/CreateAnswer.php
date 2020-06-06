<?php

namespace Anax\Questions\HTMLForm;

use Anax\HTMLForm\FormModel;
use Anax\Questions\Answer;
use Psr\Container\ContainerInterface;

/**
 * Form to create an item.
 */
class CreateAnswer extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     */
    protected $questionId;
    public function __construct(ContainerInterface $di, $id)
    {
        parent::__construct($di);
        $userName = $this->di->session->get("loggedin");
        $answerId = $this->di->session->get("answerId");
        $this->questionId = $id;
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Answer",
            ],
            [

                "questionID" => [
                    "type" => "hidden",
                    "value" => $id,
                    "validation" => ["not_empty"],
                ],

                "author" => [
                    "type" => "hidden",
                    "value" => "$userName",
                    "validation" => ["not_empty"],
                ],

                "answer" => [
                    "type" => "textarea",
                    "validation" => ["not_empty"],
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Answer",
                    "callback" => [$this, "callbackSubmit"],
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
    public function callbackSubmit(): bool
    {

        $answer = new Answer();
        $this->di->session->set("answerId", $answer->id);
        $answer->setDb($this->di->get("dbqb"));
        $answer->author = $this->form->value("author");
        $answer->text = $this->form->value("answer");
        $answer->questionID = $this->form->value("questionID");
        $answer->points = 1;
        $answer->save();
        $this->form->addOutput("Answer.");
        return true;
    }

    /**
     * Callback what to do if the form was successfully submitted, this
     * happen when the submit callback method returns true. This method
     * can/should be implemented by the subclass for a different behaviour.
     */
    public function callbackSuccess()
    {
        $this->di->get("response")->redirect("question/" . $this->questionId)->send();
        $this->form->addOutput("Answer.");
    }

    // /**
    //  * Callback what to do if the form was unsuccessfully submitted, this
    //  * happen when the submit callback method returns false or if validation
    //  * fails. This method can/should be implemented by the subclass for a
    //  * different behaviour.
    //  */
    public function callbackFail()
    {
        $this->di->get("response")->redirectSelf()->send();
        $this->form->addOutput("Answer failed.");
    }
}
