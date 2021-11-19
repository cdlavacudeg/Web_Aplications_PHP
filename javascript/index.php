<?php 
 session_start();
 require_once 'pdo.php';
 require_once 'util.php';
 $stmt = $pdo->query("SELECT profile_id,first_name,last_name,headline FROM profile");
 $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html>
<?php require_once 'head.php';?>
<body>
<div class="container">
<h1>Resume Registry</h1>
<p>
<?php 
    if (isset($_SESSION['name'])){
        
        flashMessages();

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
                echo('<a href="view.php?profile_id='.$row['profile_id'].'">'.htmlentities($row['first_name'].' '.$row['last_name']).'</a>');
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
