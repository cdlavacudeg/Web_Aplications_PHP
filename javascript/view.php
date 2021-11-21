<?php
    session_start();
    require_once 'pdo.php';
    require_once 'util.php';

    $profile=selectProfile($pdo);

    if($profile===false){
        error_log('Error value profile_id');
        $_SESSION['error']="Bad value of profile_id";
        header('Location: index.php');
        return;
    }

    $position=selectPos($pdo,$profile['profile_id']);
    $education=selectEdu($pdo,$profile['profile_id']);
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
    <div>
        <?php
        echo('<p> First name:'.$profile['first_name'].'</p>');
        echo('<p> Last name:'.$profile['last_name'].'</p>');
        echo('<p> Email:'.$profile['email'].'</p>');
        echo('<p> Headline:'.$profile['headline'].'</p>');
        echo('<p> Summary:'.$profile['summary'].'</p>');
        echo('<p> Education:');
        echo('<ul>');
        foreach($education as $edu){
        echo('<li>'.$edu['year'].': '.$edu['name'].'</li>');
        }
        echo('</ul>');
        echo('<p> Position:');
        echo('<ul>');
        foreach($position as $pos){
        echo('<li>'.$pos['year'].': '.$pos['description'].'</li>');
        }
        echo('</ul>');
        ?>
    </div>
    <p>
    <a href="index.php">Done</a>
    </p>


</div>

</body>

</html>