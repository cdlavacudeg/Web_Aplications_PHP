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
            header('Location:edit.php?autos_id='.$_REQUEST['autos_id']);
            return;
        }else {
            if(!is_numeric($_POST['mileage']) || !is_numeric($_POST['year'])){
                $_SESSION['messague']="Mileage and year must be numeric";
                header('Location:edit.php?autos_id='.$_REQUEST['autos_id']);
                return;
            }else{
                $stmt = $pdo->prepare('UPDATE autos SET make=:mk,model=:mdl, year=:yr, mileage=:mi WHERE autos_id= :autos_id');
                $stmt->execute(array(
                    ':mk' => htmlentities($_POST['make']),
                    ':mdl'=> htmlentities($_POST['model']),
                    ':yr' => htmlentities($_POST['year']),
                    ':mi' => htmlentities($_POST['mileage']),
                    ':autos_id'=> htmlentities($_POST['autos_id']))
                );
                $_SESSION['success']='Record edited';
                header("Location: index.php");
                return;
            }
        }
    }

    $stmt = $pdo->prepare("SELECT make,model, year, mileage, autos_id FROM autos where autos_id = :xyz");
    $stmt->execute(array(":xyz" => $_GET['autos_id']));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for autos_id';
    header( 'Location: index.php' ) ;
    return;
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
    <h1>Editing Automobile</h1>
    <?php 
        if ( isset($_SESSION['messague'])) { 
                echo('<p style="color: red;">'.htmlentities($_SESSION['messague'])."</p>\n");
                unset($_SESSION['messague']);
            }
    ?>

        <form method="post">
        <input type="hidden" name="autos_id" value="<?= $row['autos_id'] ?>"/>
        <p>Make:
        <input type="text" name="make" size="40" value="<?= $row['make'] ?>"/></p>
        <p>Model:
        <input type="text" name="model" size="40" value="<?= $row['model'] ?>"/></p>
        <p>Year:
        <input type="text" name="year" value="<?= $row['year'] ?>"/></p>
        <p>Mileage:
        <input type="text" name="mileage" value="<?= $row['mileage'] ?>"/></p>
        <input type="submit" value="Save">
        <input type="submit" name="cancel" value="Cancel">
        </form>
</div>

</body>

</html>