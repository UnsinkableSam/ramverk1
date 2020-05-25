<?php

namespace Anax\View;

$urlToView = url("questions");

print_r($form[0]->id);


?><h1>Question</h1>


<h3> <?= "Title: " . $form[0]->title . "<br> Author: " . $form[0]->author  ?> </h3>
<p>
    <a href="<?= $urlToView ?>">View all</a>
</p>


<?php
print_r($comments);
foreach ($answers as $value) {
  echo "<div style='border-style: solid;'>";
  print_r($value->author . "<br>");
  print_r($value->text . "<br><br>");
  echo "</div>";
  $comment = new Comment();

}
print_r($answer);
?>
