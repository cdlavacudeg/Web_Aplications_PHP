<?php 
 session_start();
 require_once 'pdo.php';
 $stmt = $pdo->query("SELECT make,model, year, mileage, autos_id FROM autos");
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
<h1>Welcome to Automobiles Database</h1>
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


        if ($rows !== false){
            echo('<table border="1">'."\n");
            echo('<tr>
                    <th>Make</th>
                    <th>Model</th>
                    <th>Year</th>
                    <th>Mileage</th>
                    <th>Action</th>
                </tr>');
            foreach($rows as $row){
                echo('<tr><td>');
                echo(htmlentities($row['make']));
                echo("</td><td>");
                echo(htmlentities($row['model']));
                echo("</td><td>");
                echo(htmlentities($row['year']));
                echo("</td><td>");
                echo(htmlentities($row['mileage']));
                echo("</td><td>");
                echo('<a href="edit.php?autos_id='.$row['autos_id'].'">Edit</a> / ');
                echo('<a href="delete.php?autos_id='.$row['autos_id'].'">Delete</a>');
                echo('</td></tr>');
            }
            echo("</table>");
        } else{
            echo('<p>No rows found</p>');
        }
    echo('<br/><p><a href="add.php">Add New Entry</a></p>');
    echo('<p><a href="logout.php">Logout</a></p>');

    }else{
        echo('<a href="login.php">Please log in</a>');
    }

?>

<!-- </p>
<p>
Attempt to go to 
<a href="edit.php">edit.php</a> without logging in - it should fail with an error message.
<p>
<p>
Attempt to go to 
<a href="add.php">add.php</a> without logging in - it should fail with an error message.
<p> -->

</div>
</body>
