<?php 
    require_once 'log_in.php';
    require_once 'pdo.php';
    

    if ( isset($_POST['cancel']) ) {
        header('Location: index.php');
        return;
    }

  
    $stmt = $pdo->prepare("SELECT user_id,profile_id,first_name, last_name, email, headline, summary FROM profile WHERE profile_id=:pid");
    $stmt->execute(array(
                ':pid' => htmlentities($_GET['profile_id']))
            );
    $profile=$stmt->fetch();
    $user_id=$profile['user_id'];

    if(isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email']) && isset($_POST['headline']) && isset($_POST['summary'])){
        if(strlen($_POST['first_name']) < 1 || strlen($_POST['last_name']) < 1 || strlen($_POST['email']) < 1 || strlen($_POST['headline']) < 1 ){
            $_SESSION['messague']="All fields are required";
            header('Location:edit.php?profile_id='.$_POST['profile_id']);
            return;
        }else {
            if(!str_contains($_POST['email'],'@')){
                $_SESSION['messague']="Email must have an at-sign (@)";
                header('Location:edit.php?profile_id='.$_POST['profile_id']);
                return;
            }else{
                
                if($user_id = $_SESSION['user_id']){
                    $stmt = $pdo->prepare(' UPDATE profile SET first_name=:fn, last_name=:ln, email=:em, headline=:he, summary=:su WHERE profile_id=:pid');
                    $stmt->execute(array(
                        ':fn' => $_POST['first_name'],
                        ':ln' => $_POST['last_name'],
                        ':em' => $_POST['email'],
                        ':he' => $_POST['headline'],
                        ':su' => $_POST['summary'],
                        ':pid'=> $_POST['profile_id'])
                    );
                    $_SESSION['success']='Profile updated';
                    header("Location:index.php");
                    exit;
                }else{
                    $_SESSION['error']="You don't own this entry";
                    header('Location:index.php');
                    return; 
                }
                
            }
        }
    }

    if($profile==false){
        header('Location: index.php');
        exit;
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
    <h1>Editing Profile</h1>
    <?php 
        if ( isset($_SESSION['messague'])) { 
                echo('<p style="color: red;">'.htmlentities($_SESSION['messague'])."</p>\n");
                unset($_SESSION['messague']);
            }
    ?>

<form method="post" action="edit.php">
        <p>First name:
        <input type="text" name="first_name" size="60" value="<?= $profile['first_name'] ?>" /></p>
        <p>Last name:
        <input type="text" name="last_name" size="60" value="<?= $profile['last_name'] ?>"/></p>
        <p>Email:
        <input type="text" name="email" size="30" value="<?= $profile['email'] ?>"/></p>
        <p>Headline:<br>
        <input type="text" name="headline" size="80" value="<?= $profile['headline'] ?>"/></p>
        <p>
            Summary:<br>
            <textarea name="summary" rows="8" cols="80" value="<?= $profile['summary'] ?>"></textarea>
        </p>
        
        <p>
        <input type="hidden" name="profile_id" value="<?= $profile['profile_id'] ?>">
        <input type="submit" value="Save">
        <input type="submit" name="cancel" value="Cancel">
        </p>
    </form>

</div>

</body>

</html>