<?php

namespace Anax\View;

use \Anax\TextFilter\TextFilter;
use Anax\User\User;

/**
 * Render content within an article.
 */
// print_r($tags[0]);



for ($i = 0; $i < count($tags); $i++) {
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
    preg_replace("/\r|\n/", "", $tagsFiltered->text);
    $url = url("showall/$value"); ?>


    <?php echo "<a href='$url'>" . $value . "</a>"; ?>
    <?php
}


$mostActiveUsers = [];



foreach ($users as $key => $value) {
    $user = new User();


    if (count($mostActiveUsers) <= 0) {
        array_push($mostActiveUsers, $value);
    } else {
        foreach ($mostActiveUsers as $number => $activeUser) {
            if ($user->activity($value->email, $this->di) > $user->activity($value->email, $this->di)) {
                array_splice($mostActiveUsers, $number, 0, $value);
            } else {
                array_push($mostActiveUsers, $value);
            }
        }
    }
}


?>
<h1>Most active users</h1>
<table>
    <tr>
        <th style=" text-align: left;" >username</th>
    </tr>
    <?php foreach ($mostActiveUsers as $key => $item) : ?>
        <tr>
            <td ><?= $item->email ?></td>
        </tr>

        <?php
        if ($key == 4) {
            break;
        }
    endforeach; ?>
</table>