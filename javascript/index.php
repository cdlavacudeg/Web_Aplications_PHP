<?php 
 session_start();
 require_once 'pdo.php';
 $stmt = $pdo->query("SELECT first_name,last_name,headline FROM profile");
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
<h1>Resume Registry</h1>
<p>
<?php 
    if (isset($_SESSION['name'])){
        
        if ( isset($_SESSION['success']) ) {
            echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
            unset($_SESSION['success']);
        }

        if ( isset($_SESSION['error']) ) {
            echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
            unset($_SESSION['error']);
        }

        echo('<p><a href="logout.php">Logout</a></p>');

        if ($rows !== false){
            echo('<table border="1">'."\n");
            echo('<tr>
                    <th>Name</th>
                    <th>Headline</th>
                    <th>Action</th>
                </tr>');
            foreach($rows as $row){
                echo('<tr><td>');
                echo(htmlentities($row['first_name'].' '.$row['last_name']));
                echo("</td><td>");
                echo(htmlentities($row['headline']));
                echo("</td><td>");
                echo('<a href="edit.php?profile_id='.$row['profile_id'].'">Edit</a> / ');
                echo('<a href="delete.php?profile_id='.$row['profile_id'].'">Delete</a>');
                echo('</td></tr>');
            }
            echo("</table>");
        } else{
            echo('<p>No rows found</p>');
        }
    echo('<br/><p><a href="add.php">Add New Entry</a></p>');
    

    }else{
        echo('<a href="login.php">Please log in</a>');
    }

?>


</div>
</body>
