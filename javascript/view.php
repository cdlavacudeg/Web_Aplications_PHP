<?php
    session_start();
    require_once 'pdo.php';
    require_once 'util.php';

    $profile=selectProfile($pdo);
    
?>

<!DOCTYPE html>
<html>
<?php require_once 'head.php';?>

<body>
<div class="container">
    <h1>Profile information</h1>
    <?php 
        flashMessages();
    ?>

    <h2>Profile</h2>
    <ul>
        <?php
        echo('<p> First name:'.$profile['first_name'].'</p>');
        echo('<p> Last name:'.$profile['last_name'].'</p>');
        echo('<p> Email:'.$profile['email'].'</p>');
        echo('<p> Headline:'.$profile['headline'].'</p>');
        echo('<p> Summary:'.$profile['summary'].'</p>');
        ?>
    </ul>
    <p>
    <a href="index.php">Done</a>
    </p>


</div>

</body>

</html>