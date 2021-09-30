<?php
require_once 'pdo.php';
// Demand a GET parameter
if ( ! isset($_GET['name']) || strlen($_GET['name']) < 1  ) {
    die('Name parameter missing');
}
$messague=false;
// If the user requested logout go back to index.php
if ( isset($_POST['logout']) ) {
    header('Location: index.php');
    return;
}

if(isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage'])){
    if(strlen($_POST['make']) < 1 ){
        $messague="Make is required";
    }else {
        if(!is_numeric($_POST['mileage']) || !is_numeric($_POST['year'])){
            $messague="Mileage and year must be numeric";
        }else{
            $stmt = $pdo->prepare('INSERT INTO autos 
            (make, year, mileage) VALUES ( :mk, :yr, :mi)');
            $stmt->execute(array(
                ':mk' => htmlentities($_POST['make']),
                ':yr' => htmlentities($_POST['year']),
                ':mi' => htmlentities($_POST['mileage']))
            );
            $messague="success";
        }
    }
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
    <h1>Traking Autos for <?php echo ($_GET['name'])?></h1>
    <?php if ( $messague !== false) { 
            if($messague!="success"){
                echo('<p style="color: red;">'.htmlentities($messague)."</p>\n");
            }else{
                echo('<p style="color: green;">'.htmlentities("Record inserted")."</p>\n");
            }
        }?>

        <form method="post">
        <p>Make:
        <input type="text" name="make" size="60"/></p>
        <p>Year:
        <input type="text" name="year"/></p>
        <p>Mileage:
        <input type="text" name="mileage"/></p>
        <input type="submit" value="Add">
        <input type="submit" name="logout" value="Logout">
        </form>
    <h2>Automobiles</h2>
    <ul>
        <?php
        foreach($rows as $row){
            echo ('<li>'.'<!--'.$row['auto_id'].'-->'.$row['year'].' '.$row['make'].' / '.$row['mileage'].'</li>');
        }
        ?>
    </ul>

</div>

</body>

</html>