<?php
    session_start();
    require_once 'pdo.php';
    if(!isset($_SESSION['name'])){
        die('Not logged in');
    }
    $stmt = $pdo->query("SELECT make, year, mileage, auto_id FROM autos");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
<title>Cristian David Lavacude Galvis</title>
<?php require_once "bootstrap.php"; ?>
</head>
<body>
<div class="container">
    <h1>Traking Autos for <?php echo ($_SESSION['name'])?></h1>
    <?php 
        if ( isset($_SESSION['success']) ) {
            echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
            unset($_SESSION['success']);
        }
    ?>

    <h2>Automobiles</h2>
    <ul>
        <?php
        foreach($rows as $row){
            echo ('<li>'.'<!--'.$row['auto_id'].'-->'.$row['year'].' '.$row['make'].' / '.$row['mileage'].'</li>');
        }
        ?>
    </ul>
    <p>
    <a href="add.php">Add New</a> |
    <a href="logout.php">Logout</a>
    </p>


</div>

</body>

</html>