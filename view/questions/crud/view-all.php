<?php
namespace Anax\View;

// print_r($items);
/**
 * View to display all books.
 */
// Show all incoming variables/functions
//var_dump(get_defined_functions());
//echo showEnvironment(get_defined_vars());

// Gather incoming variables and use default values if not set
$items = isset($items) ? $items : null;

// Create urls for navigation
$urlToCreate = url("create");




?>
<h1>View all items</h1>

<p>
    <a href="<?= $urlToCreate ?>">Create</a> 

</p>

<?php if (!$items) : ?>
<p>There are no items to show.</p>
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
    <?php foreach ($items as $item) : ?>
    <!-- <p> <?= print_r($item) ?> </p> -->
    <tr>
        <td>
            <a href="<?= url("update/{$item->id}"); ?>"><?= $item->id ?></a>
        </td>
        <td><a href="<?= url("question/{$item->id}"); ?>"> <?= $item->title ?> </a></td>
        <td><?= $item->author ?></td>
        <td><?= $item->tags ?></td>

    </tr>
    <?php endforeach; ?>
</table>


<?php if (isset($comments)) { ?>
<table>
    <tr>
        <th>Id</th>
        <th> Author</th>
        <th>Comment</th>

    </tr>
    <?php foreach ($comments as $comment) : ?>
    <!-- <p> <?= print_r($comment) ?> </p> -->
    <tr>
        <td>
            <a href="<?= url("questions/question/{$comment->id}"); ?>"><?= $comment->id ?></a>
        </td>
        <td><?= $comment->author ?></td>
        <td><?= $comment->comment ?></td>
    </tr>
    <?php endforeach; ?>
</table>
<?php }?>