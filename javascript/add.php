<?php 
    require_once 'log_in.php';
    require_once 'pdo.php';
    require_once 'util.php';
    

    if ( isset($_POST['cancel']) ) {
        header('Location: index.php');
        return;
    }
    
    
    if(isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email']) && isset($_POST['headline'])&& isset($_POST['summary']))
    {

        $msg=validateProfile();        
        if(is_string($msg)){
            $_SESSION['error']=$msg;
            header('Location:add.php');
            return;
        }

        $msg=validatePos();
        if(is_string($msg)){
            $_SESSION['error']=$msg;
            header('Location:add.php');
            return;
        }

        $stmt = $pdo->prepare('INSERT INTO profile  (user_id, first_name, last_name, email, headline, summary) VALUES ( :uid, :fn, :ln, :em, :he, :su)');
        $stmt->execute(array(
            ':uid' => $_SESSION['user_id'],
            ':fn' => htmlentities($_POST['first_name']),
            ':ln' => htmlentities($_POST['last_name']),
            ':em' => htmlentities($_POST['email']),
            ':he' => htmlentities($_POST['headline']),
            ':su' => htmlentities($_POST['summary']))
        );

        $profile_id= $pdo->lastInsertId();//function of pdo

        addPos($profile_id,$pdo);
        
        $_SESSION['success']='Record added';
        header("Location: index.php");
        return;

    }
        
?>



<!DOCTYPE html>
<html>
<?php require_once 'head.php';?>
<body>
<div class="container">
    <h1>Ading Profile for <?php echo ($_SESSION['name'])?></h1>
    <?php 
        flashMessages();
        ?>

        <form method="post">
        <p>Firt name:
        <input type="text" name="first_name" size="60"/></p>
        <p>Last name:
        <input type="text" name="last_name" size="60"/></p>
        <p>Email:
        <input type="text" name="email" size="30"/></p>
        <p>Headline:<br>
        <input type="text" name="headline" size="80"/></p>
        <p>
            Summary:<br>
            <textarea name="summary" rows="8" cols="80"></textarea>
        </p>
        
        <p>
            Position:
            <input type="submit" id="addPos" value="+">
        </p>

        <div id="position_fields"></div>

        <p>
        <input type="submit" value="Add">
        <input type="submit" name="cancel" value="Cancel">
        </p>
    </form>
</div>
<script
  src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"
  integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30="
  crossorigin="anonymous">

</script>
  
  <script
  src="https://code.jquery.com/jquery-3.6.0.js"
  integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
  crossorigin="anonymous">
</script>


<script>
    countPos=0;
    $(document).ready(function(){
        window.console && console.log("Document ready called");

        $('#addPos').click(function(event){
            event.preventDefault();

            if(countPos>=9){
                alert("Maximum of nine positions exceeded");
                return;
            }
            countPos++;
            window.console && console.log("Adding position "+countPos);

            $('#position_fields').append(
                '<div id="position'+countPos+'"> \
                <p>Year: <input type="text" name="year'+countPos+'" value="" /> \
                    <input type="button" value="-" \
                    onclick="$(\'#position'+countPos+'\').remove(); return false;"></p>\
                    <textarea name="desc'+countPos+'" rows="8" cols="80"></textarea>\
                </div>');

        });  

          
    });

</script>

</body>

</html>