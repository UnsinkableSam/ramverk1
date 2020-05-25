<?php
namespace Anax\View;
use \Anax\TextFilter\TextFilter;
use Anax\Questions\HTMLForm\CreateComment;
use Anax\Questions\HTMLForm\voteForm;


$urlToView = url("questions");
$urlTest = url("questions/user");
$filter = new TextFilter();
$filters = ["markdown"];
$urlsend = url("VoteApi/test");
$di->get("session")->set("VoteAction", 1);


// vote form funkar inte som tänkt. Det blir inte e variable. 

?>


<style> 
        .tab1 { 
            tab-size: 2; 
        } 
  
        .tab2 { 
            tab-size: 4; 
        } 
  
        .tab4 { 
            padding-left: 2rem;
        } 
    </style> 

<div id='answerBorder' style="background-color:transparent">
    <div id='answerTextMargin'>

        <!--
  This is where we print out the question information for the thread topic.
  -->
        <?php 
        $filteredQAuthor = $filter->parse("Author: " .  $question[0]->author, $filters); 
        $filteredQTitle = $filter->parse("Title: " .  $question[0]->title, $filters); 
        print_r("<h2> " . $filteredQAuthor->text  . "</h2>" );
        ?>

        <h3> <?php print_r($filteredQTitle->text) ; ?> </h3>
        <?php 
        // $voteForm = new voteForm($this->di, $question[0]->author, $question[0]->id); 
        //   print_r($voteForm->getHTML()); 
          ?>
        <?php print_r( $question[0]->text); ?>
        <?php 
          $valueId = $question[0]->id;        

          
          
      ?>
    </div>


    <?php
  /*
  *Print out the comments for the question / thread topic.
  *
  */
  echo "<div style='background-color:lightgray' id='commentSection'>";
  echo "<h3> comments </h3>";
  foreach ($questionComments as $value) {
    $filteredAuthor = $filter->parse("Author:" .  $value->author, $filters); 
    $filteredcomment = $filter->parse($value->comment, $filters); 
    if ($value->answerId == "0") {
      echo "<div class='tab4'  id='commentText';'>";
      echo $filteredAuthor->text;
      echo "Comment: " .  $filteredcomment->text . "<br>";
      echo "</div>";
      
    }

  }
  print_r($commentForm);
  echo "</div>";
  
?>
</div>


<div class="" style="background-color:transparent">
    <br>
    <?php
$i = 0;
  foreach ($questionAnswers as $value) {
    $filteredAuthorQ = $filter->parse($value->author, $filters); 
    $filteredtextQ = $filter->parse($value->text, $filters); 
    echo "<div id='answerBorder'>";
    echo "<h1> Answer</h1>";
    echo "<div id='answerTextMargin'>";
    // echo ":  " . $value->id . "<br>";
    // echo "<h2> Author: " .  $filteredAuthorQ->text . "</h2>";
    $filteredAuthor = $filter->parse("Author:" .  $value->author, $filters); 
    echo $filteredAuthor->text;
    // echo "hello11123333";
    // echo "<input href="" type='submit' name='vote' value='Upvote' /> <br>";


    // $di, $email, $threadId = null, $commentId = null  ,$answerId = null
    echo "Answer: " .  $filteredtextQ->text;
    echo "</div>";

    /*
    *
    *This second foreach is to print out comments to the answers.
    */
    echo  "<div style='background-color:lightgray' id='commentSection'>";
    echo "<h3> comments </h3>";
    echo "<div>";
    foreach ($questionComments as $comment) {
      $userUrl = url("questions/user/" . $comment->author );
      $commentAuthor = $filter->parse("Author:  "."<a href='$userUrl'>". $comment->author ."</a>", $filters) ; 
      $commentText = $filter->parse("Comment: " .$comment->comment, $filters); 
      if ($comment->answerId == $value->id ) {
        ?>
        <div class='tab4' id='commentText'>
        <h4><?= $commentAuthor->text ?></h4>
        <p class="tab4"><?= " " .  $commentText->text ?></p>
        </div>
        <?php
      }
    }
    echo "</div>";
      print_r($answersHtmls[$i]);
    echo "</div>";
    echo "</div>";
    $i++;
  }

  /*
  *
  *Print out the comment field for answers.
  * var $answerForm is a array with pre loaded forms with specific ids for
  * comments html code.
  */
  print_r($answerForm);


  
?>
</div>