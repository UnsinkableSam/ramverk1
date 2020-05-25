<?php

namespace Anax\View;


$urlToView = url("questions");



?>
<?php print_r($answer);



 ?>


<div class="" style="background-color:red;">
    <?php print_r($answers[0]->author); ?>
    <div class="">
        <?php print_r($answers[0]->title); ?>
        <div class="">
            <?php print_r($answers[0]->text); ?>
        </div>
        <?php
      if ($commentsAnswer) {


        echo "<br>";
        foreach ($commentsAnswer as $value) {
          if ($value->answerId == $answers[0]->id){

          }
          echo $value->author . "<br>";
          echo $value->text . "<br>";
          echo $value->author . "<br> <br> <br>" ;
          // echo $key ." ". $value . "<br>";
        }
      }
      ?>
    </div>
    <?php print_r($comment); ?>
</div>