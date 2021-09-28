<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cristian Lavacude PHP</title>
</head>
<body>
    <h1>Cristian Lavacude PHP</h1>
    <?php
    $hash= hash('sha256','Cristian Lavacude');
    echo "The SHA256 hash of \"Cristian Lavacude\" is ".$hash;
    ?>
    <pre>ASCII ART:
        ***********
        ***********
        * *
        * *
        * *
        * *
        ***********
        ***********
</pre>

<a href="check.php">Click here to check the error setting</a>
<br/>
<a href="fail.php">Click here to cause a traceback</a>
</body>
</html>