<?php 
    require_once 'log_in.php';
    require_once "pdo.php";

  
    $stmt = $pdo->prepare("SELECT user_id,profile_id,first_name FROM profile WHERE profile_id=:pid");
    $stmt->execute(array(
                    ':pid' => htmlentities($_GET['profile_id']))
                );
    $profile=$stmt->fetch();

    if ( $profile === false ) {
    $_SESSION['error'] = 'Bad value for profile_id';
    header( 'Location: index.php' ) ;
    return;
    }

    if ( isset($_POST['delete']) && isset($_POST['profile_id']) ) {
        if($profile['user_id']==$_SESSION['user_id']){
            $sql = "DELETE FROM profile WHERE profile_id = :zip";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(':zip' => $_POST['profile_id']));
            $_SESSION['success'] = 'Record deleted';
            header( 'Location: index.php' ) ;
            return;
        }else{
            $_SESSION['error']="You don't own this entry";
            header('Location:index.php');
            return; 
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
<p>Confirm: Deleting <?= htmlentities($profile['first_name']) ?></p>
<form method="post"><input type="hidden"
name="profile_id" value="<?= $profile['profile_id'] ?>">
<input type="submit" value="Delete" name="delete">
<a href="index.php"> Cancel</a>
</form>

</div>
</body>