<?php

namespace Anax\User\HTMLForm;

use Anax\HTMLForm\FormModel;
use Anax\User\User;
use Psr\Container\ContainerInterface;

/**
 * Example of FormModel implementation.
 * @SuppressWarnings(PHPMD)
 */
class UpdateUserForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di)
    {
        parent::__construct($di);
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Create user",
            ],
            [
                 "Currentemail" => [
                    "type" => "hidden",
                    "value" =>  $userName = $this->di->session->get("loggedin"),
                 ],

                 "email" => [
                    "type" => "text",
                 ],

                 "presentation" => [
                    "type" => "textarea",
                 ],

                 "password" => [
                    "type" => "password",
                 ],

                 "password-again" => [
                    "type" => "password",
                    "validation" => [
                        "match" => "password",
                     ],
                 ],

                 "submit" => [
                    "type" => "submit",
                    "value" => "Update user",
                    "callback" => [$this, "callbackSubmit"],
                 ],

            ]
        );
    }

    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return boolean true if okey, false if something went wrong.
     */
    public function callbackSubmit()
    {
        // Get values from the submitted form
        $currentEmail = $this->form->value("Currentemail");
        $email = $this->form->value("email");
        $password = $this->form->value("password");
        $passwordAgain = $this->form->value("password-again");
        $bio = $this->form->value("presentation");
        // Check password matches
        if ($password !== $passwordAgain) {
            $this->form->rememberValues();
            $this->form->addOutput("Password did not match.");
            return false;
        }

        // Save to database
        // $db = $this->di->get("dbqb");
        // $password = password_hash($password, PASSWORD_DEFAULT);
        // $db->connect()
        //    ->insert("User", ["acronym", "password"])
        //    ->execute([$acronym])
        //    ->fetch();

        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $user->email = $email;
        $user->password = $password;
        $user->bioText = $bio;
        $user->updateUser($currentEmail);
        //$user->save();
        $this->di->session->set("loggedin", $email);
        $this->form->addOutput("User was Updated.");
        return true;
    }
}
