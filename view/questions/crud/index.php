<?php

namespace Anax\View;
use \Anax\TextFilter\TextFilter;
/**
 * Render content within an article.
 */
// print_r($tags[0]);

for ($i=0; $i < count($tags); $i++) { 
    $tagsArr[$i] = $tags[$i]->tags;
}


$array = array_count_values($tagsArr);



$values = array_count_values($tagsArr);
arsort($values);
$popular = array_slice(array_keys($values), 0, 5, true);





// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());
// Prepare classes
$classes[] = "article";
if (isset($class)) {
    $classes[] = $class;
}


?><article <?= classList($classes) ?>>
<?= $content ?>
</article>


<h1>Latest questions</h1>
<?php if (!$questions) : ?>
<p>There are no ques$questions to show.</p>
<?php
    return;
endif;
?>

<table>
    <tr>
        <th>Id</th>
        <th>Title</th>
        <th>Author</th>
        <th>Tags</th>
    </tr>
    <?php foreach ($questions as $key => $item) : ?>
    <!-- <p> <?= print_r($item) ?> </p> -->
    <tr>
        <td>
            <a href="<?= url("update/{$item->id}"); ?>"><?= $item->id ?></a>
        </td>
        <td><a href="<?= url("question/{$item->id}"); ?>"> <?= $item->title ?> </a></td>
        <td><?= $item->author ?></td>
        <td><?= $item->tags ?></td>

    </tr>
    
    <?php
    if ($key == 4) {
        break;
    }

    endforeach; ?>
</table>

<?php
$filter = new TextFilter();
$filters = ["markdown"];
echo "<h3> Most popular tags</h3>";
?>

    <?php 

       
foreach ($popular as $key => $value) {


  $tagsFiltered = $filter->parse($value, $filters);
  preg_replace( "/\r|\n/", "", $tagsFiltered->text );
  $url = url("tags/$value");
  ?>

  
        <?php echo "<a href='$url'>" . $value . "</a>";  ?>



    <?php
  
}

?>
