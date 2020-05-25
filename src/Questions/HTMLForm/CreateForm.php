<?php

namespace Anax\Questions\HTMLForm;
use Anax\HTMLForm\FormModel;
use \Anax\TextFilter\TextFilter;
use Psr\Container\ContainerInterface;
use Anax\Questions\Questions;
use Anax\Questions\Comments;
use Anax\Questions\Tags;
use Anax\Questions\HTMLForm\CreateComment;
/**
 * Form to create an item.
 */
class CreateForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di)
    {
        

        // print_r($di->getServices());
        // print_r("\n");
        // print_r($di->get("textfilter"));
        // print_r($di->get("textfilter"));
        $filter = new TextFilter();
        $filters = ["shortcode", "markdown", "clickable", "bbcode"];
        parent::__construct($di);
        $userName = $this->di->session->get("loggedin");
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Details of the Question",
            ],
            [
                "title" => [
                    "type" => "text",
                    "validation" => ["not_empty"],
                ],

                "author" => [
                    "type" => "hidden",
                    "value" => $userName,
                    "validation" => ["not_empty"],
                ],

                "text" => [
                    "type" => "textarea",
                    "validation" => ["not_empty"],
                ],

                "tags" => [
                    "type" => "text",
                    "validation" => ["not_empty"],
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Create item",
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
        // $filter = new TextFilter();
        // $filters = ["shortcode", "markdown", "clickable", "bbcode"];
        $questions = new Questions();
        echo "hello";
        $this->form->addOutput($this->di->get("response"));
        $questions->setDb($this->di->get("dbqb"));
        
        $questions->title  = $this->form->value("title");
        
        $tagAdded = "";
        print_r($questions);
        $tagsList = $this->form->value("tags");
        $tagsArray = explode(" ", $tagsList);
        foreach ($tagsArray as $value) {
          $tags = new Tags();
          $tags->setDb($this->di->get("dbqb"));
          $tags->tags  = $value . ",";
          $tagAdded = $tagAdded . $value . ",";
          $tags->threadId = $this->form->value("title");
          $tags->save();
        }
        $questions->author = $this->form->value("author");
        $questions->text = $this->form->value("text");
        $questions->tags  = $tagAdded;
        $questions->save();
        return true;
    }



    /**
     * Callback what to do if the form was successfully submitted, this
     * happen when the submit callback method returns true. This method
     * can/should be implemented by the subclass for a different behaviour.
     */
    public function callbackSuccess()
    {
        $this->di->get("response")->redirect("showall")->send();
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
        $this->form->addOutput($this->di->get("response"));
        echo "lol";
    }


    public function testPrint() {

        $filter = new TextFilter();
        $filters = ["shortcode", "markdown", "clickable", "bbcode"];
        print_r($this->form->value("title"));
        $filter->parse($this->form->value("title"), $filters);
        print_r($this->form->value("title"));
    }



    
}