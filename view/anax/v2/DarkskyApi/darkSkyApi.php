<?php
namespace Anax\View;

?>

<h4> använda koordinater format-> "56.2, 15.5167" eller ipAdress </h4>
<h3>Dark sky use cordinates or ip adress</h3>
<form class="" action="darkSkyController/dark" method="Post">
    <?php
    echo "Weather search ";
    echo "<br>";
    echo '<input type="text" name="ip" value="">';
    echo "<br>";
    echo '<input type="text" name="date" placeholder="YYYY-MM-DDTHH:MM:SS" value="">';
    echo "<br>";
    ?>
    <input type="submit" name="submit">
</form>
