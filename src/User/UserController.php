<?php

namespace Anax\User;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Anax\Questions\Answer;
use Anax\Questions\Comments;
use Anax\Questions\Questions;
use Anax\User\HTMLForm\CreateUserForm;
use Anax\User\HTMLForm\UpdateUserForm;
use Anax\User\HTMLForm\UserLoginForm;
use Anax\User\HTMLForm\UserPage;
use Anax\User\User;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class UserController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    /**
     * @var $data description
     */
    //private $data;

    // /**
    //  * The initialize method is optional and will always be called before the
    //  * target method/action. This is a convienient method where you could
    //  * setup internal properties that are commonly used by several methods.
    //  *
    //  * @return void
    //  */
    // public function initialize() : void
    // {
    //     ;
    // }

    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function indexActionGet(): object
    {
        $page = $this->di->get("page");

        $page->add("anax/v2/article/default", [
            "content" => "An index page",
        ]);

        return $page->render([
            "title" => "A index page",
        ]);
    }

    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function loginAction(): object
    {
        $page = $this->di->get("page");
        $form = new UserLoginForm($this->di);
        $form->check();
        if ($this->di->session->has("loggedin") != null) {
            $this->di->get("response")->redirect("user/user");
        }
        $page->add("anax/v2/article/default", [
            "content" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "A login page",
        ]);
    }

    public function logoutAction(): object
    {
        $this->di->session->set("loggedin", null);
        $page = $this->di->get("page");
        $form = new UserLoginForm($this->di);
        $form->check();
        if ($this->di->session->get("loggedin") == null) {
            $this->di->get("response")->redirect("");
        }
        $page->add("anax/v2/article/default", [
            "content" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "A login page",
        ]);
    }
    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function createAction(): object
    {
        $page = $this->di->get("page");
        $form = new CreateUserForm($this->di);
        $form->check();

        $page->add("anax/v2/article/default", [
            "content" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "A create user page",
        ]);
    }



    public function bioAction(): object
    {
        $page = $this->di->get("page");
        $form = new UpdateUserForm($this->di);
        $form->check();

        $page->add("anax/v2/article/default", [
            "content" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "A create user page",
        ]);
    }

    public function userAction($email = null): object
    {
        $page = $this->di->get("page");
        $userPage = new UserPage($this->di);
        $userPage->check();
        $res = $userPage->userInfo();
        $currentUser = $this->di->session->get("loggedin");
        if ($email !== null) {
            $res[0]->email = $email;
        }
        if ($res) {
            $avatar = $userPage->getGravatar($res[0]->email);
            $user = new User($this->di);
            $questions = new Questions($this->di);
            $comments = new Comments($this->di);
            $answers = new Answer($this->di);

            $userAnswers = $answers->userAnswers($res[0]->email, $this->di);
            $userComments = $comments->userComments($res[0]->email, $this->di);
            $userQuestions = $questions->indexUser($res[0]->email, $this->di);
            $userCommentLength = count($userComments);
            $userAnswerLength = count($userAnswers);
            $userQuestionsLength = count($userQuestions);
            for ($i = 0; $i < $userCommentLength; $i++) {
                $userComments[$i]->questionTitle = $questions->userInfo($userComments[$i]->threadId, $this->di);
            }

            for ($i = 0; $i < $userAnswerLength; $i++) {
                $userAnswers[$i]->questionTitle = $questions->userInfo($userAnswers[$i]->questionID, $this->di);
            }

            $answeresOfQuestion = [];
            for ($i = 0; $i < $userQuestionsLength; $i++) {
                $answerQ = $user->questionAnswered($userQuestions[$i]->id, $this->di);
                array_push($answeresOfQuestion, $answerQ);
            }

            $totalPoints = $user->totalPoints($res[0]->email, $this->di);
            $page->add("anax/v2/user/userpage", [
                "res" => $res,
                "avatar" => $avatar,
                "content" => $userPage->getHTML(),
                "email" => $res[0]->email,
                "totalPoints" => $totalPoints,
                "questions" => $userQuestions,
                "comments" => $userComments,
                "answeresOfQuestion" => $answeresOfQuestion,
                "answers" => $userAnswers,
                "currentUser" => $currentUser,

            ]);
        }

        if (!$res) {
            $message = "not logged in";
            $page->add("anax/v2/error/default", [
                "message" => $message,
                "header" => "Login error",
                "text" => "$message",
            ]);
        }

        return $page->render([
            "title" => "A user page",
        ]);
    }
}
