<?php if ($res): ?>


<?php print_r("<h1>" . $res[0]->email . "</h1>" ?? "<br><h3> No logged in </h3>"); 


?>

<img src="<?php echo $avatar ?>" alt="Avatar">
<br>

  
<?php endif ?>

<?php if (count($questions) !== 0) { ?>
<h1>Questions</h1>
<table class="table">
  <thead>
    <tr>
      <th scope="col">Link</th>
      <th scope="col">title</th>
      <th scope="col">Author</th>
      <th scope="col">Answers</th>
    </tr>
  </thead>
  <tbody>
  <?php for ($j=0; $j < count($questions) ; $j++) {  ?> 
    <tr>
      <!-- <td> <?= $questions[$j]->id ?></td> -->
      <td><a href="<?= "../questions/question/" . $questions[$j]->id ?>"> Link </a></td>
      <td><?= $questions[$j]->title ?></td>
      <td><?= $questions[$j]->author ?></td>
      <td><?= $answeresOfQuestion[$j] ?></td>
     
    </tr>
    <?php   
  } ?>
  </tbody>
</table>
<?php } ?>


<?php if (count($comments) !== 0) { ?>

<h1>Comments</h1>
<table class="table">
  <thead>
    <tr>
      <th>Question title</th>
      <th scope="col">Link</th>
      <th scope="col">Author</th>
    </tr>
  </thead>
  <tbody>
  <?php for ($i=0; $i < count($comments) ; $i++) {  ?> 
    <tr>
    <td><?= $comments[$i]->questionTitle[0]->title  ?></td>
      <td><a href="<?= "../questions/question/" . $comments[$i]->threadId ?>"> Link </a></td>
      <td><?= $comments[$i]->author ?></td>
    </tr>
    <?php   
  } ?>
  </tbody>
</table>
<?php
 
} ?>


<?php if (count($answers) !== 0) { ?>

<h1>answered questions</h1>
<table class="table">
  <thead>
    <tr>
      <td>Question Title</td>
      <th scope="col">Link</th>
      <th scope="col">Author</th>
    </tr>
  </thead>
  <tbody>
  <?php for ($i=0; $i < count($answers) ; $i++) {  ?> 
    <tr>
      <td><?= $answers[$i]->questionTitle[0]->title ?></td>
      <td><a href="<?= "../questions/question/" . $answers[$i]->questionID ?>"> Link </a></td>
      <td><?= $answers[$i]->author ?></td>
    </tr>
    <?php   
  } ?>
  </tbody>
</table>
<?php
 
} ?>
