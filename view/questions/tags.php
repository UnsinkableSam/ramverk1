<?php
namespace Anax\View;
use \Anax\TextFilter\TextFilter;
$tagsArr = array();
$filter = new TextFilter();
$filters = ["markdown"];
echo "<h3> Tags</h3>";

?>

    <?php 
foreach ($tags as $value) {


  if (!(in_array($value->tags, $tagsArr)) || count($tagsArr) == 0  ) 
  {


    
    $tagsFiltered = $filter->parse($value->tags, $filters);
    preg_replace( "/\r|\n/", "", $tagsFiltered->text );
    $url = url("showall/$value->tags");
    ?>


            <?php echo "<a href='$url'>" . $value->tags . "</a>";  ?>



    <?php
    array_push($tagsArr, $value->tags);     
}
}

?>
