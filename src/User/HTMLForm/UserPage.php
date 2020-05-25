<?php

namespace Anax\User\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Anax\User\User;

/**
 * Example of FormModel implementation.
 */
class UserPage extends FormModel
{



    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     */


    public function __construct(ContainerInterface $di)
    {
        parent::__construct($di);
        $userName = $this->di->session->get("loggedin") ?? "";
        $this->form->create(
          [
              "id" => __CLASS__,
              "legend" => "Update user",
          ],
          [
              "email" => [
                  "type"        => "hidden",
                  "value"       => "$userName",
              ],

              "password" => [
                  "type"        => "password",
              ],

              "password-again" => [
                  "type"        => "password",
                  "validation" => [
                      "match" => "password"
                  ],
              ],

              "submit" => [
                  "type" => "submit",
                  "value" => "Update user",
                  "callback" => [$this, "callbackSubmit"]
              ],

          ]
        );


    }

    function get_gravatar( $email, $s = 80, $d = 'mp', $r = 'g', $img = false, $atts = array() ) {
        $url = 'https://www.gravatar.com/avatar/';
        $url .= md5( strtolower( trim( $email ) ) );
        $url .= "?s=$s&d=$d&r=$r";
        if ( $img ) {
            $url = '<img src="' . $url . '"';
            foreach ( $atts as $key => $val )
                $url .= ' ' . $key . '="' . $val . '"';
            $url .= ' />';
        }
        return $url;
    }

    /**
   * Callback for submit-button which should return true if it could
   * carry out its work and false if something failed.
   *
   * @return boolean true if okey, false if something went wrong.
   */
  public function userInfo()
  {
      $user = new User();
      $user->setDb($this->di->get("dbqb"));
      $idUser = $this->di->session->get("loggedin") ?? "";
      $res = $user->findAllWhere("email = ?", $idUser);

      // if (!$res) {
      //    $res = "Not logged in as a user";
      // }
      return $res;
  }



  public function callbackSubmit()
  {

      // Get values from the submitted form
      $email       = $this->form->value("email");
      $password      = $this->form->value("password");
      $passwordAgain = $this->form->value("password-again");

      // Check password matches
      if ($password !== $passwordAgain ) {
          $this->form->rememberValues();
          $this->form->addOutput("Password did not match.");
          return false;
      }


      $user = new User();
      $user->setDb($this->di->get("dbqb"));
      $user->email = $email;
      $user->setPassword($password);
      $res = $user->findAllWhere("email = ?", $email);
      $user->updateUser($password);

      $this->form->addOutput("User was updated");
      return true;
  }



}
