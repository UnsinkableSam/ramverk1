<?php

namespace Anax\Questions;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Anax\Questions\HTMLForm\CreateAnswer;
use Anax\Questions\HTMLForm\CreateComment;
use Anax\Questions\HTMLForm\CreateForm;
use Anax\Questions\HTMLForm\DeleteForm;
use Anax\Questions\HTMLForm\UpdateForm;
use Anax\Questions\Tags;

// use Anax\Questions\HTMLForm\Test;
// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class QuestionsContoller implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    /**
     * @var $data description
     */
    //private $data;

    public function indexActionGet()
    {
        // Get the current route and see if it matches a content/file

        //   $file1 = ANAX_INSTALL_PATH . "/content/{$path}.md";
        //   $file2 = ANAX_INSTALL_PATH . "/content/{$path}/index.md";

        //   $file = is_file($file1) ? $file1 : null;
        //   $file = is_file($file2) ? $file2 : $file;

        $questions = new Questions();
        $questions->setDb($this->di->get("dbqb"));

        $tagsClass = new Tags();
        $tags = $tagsClass->getTags($this->di);

        $file = ANAX_INSTALL_PATH . "/content/index.md";

        if (!$file) {
            return;
        }

        // Check that file is really in the right place
        $real = realpath($file);
        $base = realpath(ANAX_INSTALL_PATH . "/content/");
        if (strncmp($base, $real, strlen($base))) {
            return;
        }

        // Get content from markdown file
        $content = file_get_contents($file);
        $content = $this->di->get("textfilter")->parse(
            $content,
            ["frontmatter", "variable", "shortcode", "markdown", "titlefromheader"]
        );

        // Add content as a view and then render the page
        $page = $this->di->get("page");
        $page->add("questions/crud/index", [
            "content" => $content->text,
            "frontmatter" => $content->frontmatter,
            "questions" => $questions->indexFind(null, $this->di),
            "tags" => $tags,
        ]);

        return $page->render($content->frontmatter);
    }

    public function omAction()
    {
        // Get the current route and see if it matches a content/file

        //   $file1 = ANAX_INSTALL_PATH . "/content/{$path}.md";
        //   $file2 = ANAX_INSTALL_PATH . "/content/{$path}/index.md";

        //   $file = is_file($file1) ? $file1 : null;
        //   $file = is_file($file2) ? $file2 : $file;

        $file = ANAX_INSTALL_PATH . "/content/om.md";

        if (!$file) {
            return;
        }

        // Check that file is really in the right place
        $real = realpath($file);
        $base = realpath(ANAX_INSTALL_PATH . "/content/");
        if (strncmp($base, $real, strlen($base))) {
            return;
        }

        // Get content from markdown file
        $content = file_get_contents($file);
        $content = $this->di->get("textfilter")->parse(
            $content,
            ["frontmatter", "variable", "shortcode", "markdown", "titlefromheader"]
        );

        // Add content as a view and then render the page
        $page = $this->di->get("page");
        $page->add("anax/v2/article/default", [
            "content" => $content->text,
            "frontmatter" => $content->frontmatter,
        ]);

        return $page->render($content->frontmatter);
    }

    /**
     * Show all items.
     *
     * @return object as a response object
     */
    public function showallAction($search = null): object
    {
        $page = $this->di->get("page");
        $questions = new Questions();
        $questions->setDb($this->di->get("dbqb"));

        $page->add("questions/crud/view-all", [
            "items" => $questions->indexFind($search, $this->di),
        ]);

        return $page->render([
            "title" => "A collection of items",
        ]);
    }

    /**
     * Handler with form to create a new item.
     *
     * @return object as a response object
     */
    public function createAction(): object
    {
        $page = $this->di->get("page");
        $form = new CreateForm($this->di);
        $form->check();

        $page->add("questions/crud/create", [
            "form" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "Create a item",
        ]);
    }

    /**
     * Handler with form to delete an item.
     *
     * @return object as a response object
     */
    public function deleteAction(): object
    {
        $page = $this->di->get("page");
        $form = new DeleteForm($this->di);
        $form->check();

        $page->add("questions/crud/delete", [
            "form" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "Delete an item",
        ]);
    }

    /**
     * Handler with form to update an item.
     *
     * @param int $id the id to update.
     *
     * @return object as a response object
     */
    public function updateAction(int $id): object
    {
        $page = $this->di->get("page");
        $form = new UpdateForm($this->di, $id);
        $form->check();

        $page->add("questions/crud/update", [
            "form" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "Update an item",
        ]);
    }

    public function questionAction($questionId): object
    {

        //   $filter = new TextFilter();
        //   $filters = ["shortcode", "markdown", "clickable", "bbcode"];
        //   print_r($form);
        //   foreach($form as $key => $value){
        //       $form[$key] = $filter->parse($value, $filters);
        //     }
        $page = $this->di->get("page");
        $questions = new Questions();
        $questions->setDb($this->di->get("dbqb"));
        $answerForm = new CreateAnswer($this->di, $questionId);
        $commentForm = new CreateComment($this->di, $questionId);

        $commentForm->check();
        $answerForm->check();
        $answers = $questions->answers($questionId, $this->di);

        $page->add("questions/crud/question", [
            "question" => $questions->userInfo($questionId, $this->di),
            "questionComments" => $questions->comments($questionId, $this->di),
            "questionAnswers" => $answers,
            "answerForm" => $answerForm->getHTML(),
            "commentForm" => $commentForm->getHTML(),
            "answersHtmls" => $questions->answersForms($answers, $this->di, $questionId),

        ]);

        return $page->render([
            "title" => "Update an item",
        ]);
    }
    public function tagsAction()
    {
        $page = $this->di->get("page");
        $tagsClass = new Tags();
        $tags = $tagsClass->getTags($this->di);
        $page->add("questions/tags", [
            "tags" => $tags,
        ]);

        return $page->render([
            "title" => "Tags",
        ]);
    }

    public function userActionGet($search = null): object
    {
        $page = $this->di->get("page");
        $questions = new Questions();
        $questions->setDb($this->di->get("dbqb"));

        $page->add("questions/crud/view-all", [
            "items" => $questions->indexUser($search, $this->di),
            "comments" => $questions->indexUserComments($search, $this->di),
        ]);

        return $page->render([
            "title" => "A collection of items",
        ]);
    }

    public function homeAction(): object
    {
        $page = $this->di->get("page");
        $tagsClass = new Tags();
        $tags = $tagsClass->getTags($this->di);
        $page->add("questions/tags", [
            "tags" => $tags,
        ]);

        return $page->render([
            "title" => "Tags",
        ]);
    }
}
