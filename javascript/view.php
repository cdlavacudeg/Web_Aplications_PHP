<?php
    session_start();
    require_once 'pdo.php';
    $stmt = $pdo->prepare("SELECT first_name, last_name, email, headline, summary FROM profile WHERE profile_id=:pid");
    $stmt->execute(array(
        ':pid' => htmlentities($_GET['profile_id']))
    );
    $profile=$stmt->fetch();
    
?>

<!DOCTYPE html>
<html>
<head>
<title>Cristian David Lavacude Galvis</title>
<?php require_once "bootstrap.php"; ?>
</head>
<body>
<div class="container">
    <h1>Profile information</h1>
    <?php 
        if ( isset($_SESSION['success']) ) {
            echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
            unset($_SESSION['success']);
        }
    ?>

    <h2>Automobiles</h2>
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