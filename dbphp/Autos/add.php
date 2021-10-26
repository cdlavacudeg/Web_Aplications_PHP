<?php 
    session_start();
    require_once 'pdo.php';
    if(!isset($_SESSION['name'])){
        die('Not logged in');
    }

    if ( isset($_POST['cancel']) ) {
        header('Location: view.php');
        return;
    }


    if(isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage'])){
        if(strlen($_POST['make']) < 1 ){
            $_SESSION['messague']="Make is required";
            header('Location:add.php');
            return;
        }else {
            if(!is_numeric($_POST['mileage']) || !is_numeric($_POST['year'])){
                $_SESSION['messague']="Mileage and year must be numeric";
                header('Location:add.php');
                return;
            }else{
                $stmt = $pdo->prepare('INSERT INTO autos 
                (make, year, mileage) VALUES ( :mk, :yr, :mi)');
                $stmt->execute(array(
                    ':mk' => htmlentities($_POST['make']),
                    ':yr' => htmlentities($_POST['year']),
                    ':mi' => htmlentities($_POST['mileage']))
                );
                $_SESSION['success']='Record inserted';
                header("Location: view.php");
                return;
            }
        }
    }
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
        if ( isset($_SESSION['messague'])) { 
                echo('<p style="color: red;">'.htmlentities($_SESSION['messague'])."</p>\n");
                unset($_SESSION['messague']);
            }
        ?>

        <form method="post">
        <p>Make:
        <input type="text" name="make" size="60"/></p>
        <p>Year:
        <input type="text" name="year"/></p>
        <p>Mileage:
        <input type="text" name="mileage"/></p>
        <input type="submit" value="Add">
        <input type="submit" name="cancel" value="Cancel">
        </form>
</div>

</body>

</html>