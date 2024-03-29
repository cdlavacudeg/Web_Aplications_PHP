<?php 
    session_start();
    require_once 'pdo.php';
    if(!isset($_SESSION['name'])){
        die("ACCESS DENIED");
    }

    if ( isset($_POST['cancel']) ) {
        header('Location: index.php');
        return;
    }
    
    
    if(isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage']) && isset($_POST['model'])){
        if(strlen($_POST['make']) < 1 || strlen($_POST['year']) < 1 || strlen($_POST['mileage']) < 1 || strlen($_POST['model']) < 1){
            $_SESSION['messague']="All fields are required";
            header('Location:add.php');
            return;
        }else {
            if(!is_numeric($_POST['mileage']) || !is_numeric($_POST['year'])){
                $_SESSION['messague']="Mileage and year must be numeric";
                header('Location:add.php');
                return;
            }else{
                $stmt = $pdo->prepare('INSERT INTO autos 
                (make,model, year, mileage) VALUES ( :mk,:mdl,:yr, :mi)');
                $stmt->execute(array(
                    ':mk' => htmlentities($_POST['make']),
                    ':mdl'=> htmlentities($_POST['model']),
                    ':yr' => htmlentities($_POST['year']),
                    ':mi' => htmlentities($_POST['mileage']))
                );
                $_SESSION['success']='Record added';
                header("Location: index.php");
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
        <input type="text" name="make" size="40"/></p>
        <p>Model:
        <input type="text" name="model" size="40"/></p>
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