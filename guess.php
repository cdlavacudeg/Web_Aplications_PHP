<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cristian David Lavacude Galvis 484c907e</title>

</head>
<body>
    <h1>Welcome to my guessing game</h1>
    <p>
        <?php

            $guessNumber=$_GET['guess']??'no';
            $correct=62;
            if ($guessNumber=='no'){
                print("Missing guess parameter");
            }elseif($guessNumber==null){
                print("Your guess is too short");
            }elseif(!is_numeric($guessNumber)){
                print("Your guess is not a number");
            }elseif($guessNumber<62){
                print("Your guess is too low");
            }elseif($guessNumber>62){
                print("Your guess is too high");
            }else{
                print("Congratulations - You are right");
            }
        ?>
    </p>
    
</body>
</html>