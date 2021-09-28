<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cristian David Lavacude Galvis PHP</title>
</head>
<body>
    <h1>MD5 CRAKER</h1>
    <p>This application takes an MD5 hash of a four digit pin and check all 10,000 possible four digit PINs to determine the pin</p>

    <pre>
        Debug output:
        <?php   
        $pin="Not Found";

        if (isset($_GET['md5'])){
            $time_pre=microtime(true);
            $md5=$_GET['md5'];
            $total=0;

            $numbers="0123456789";
            $show=15;

            for ($i=0;$i<strlen($numbers);$i++){
                $number1=$numbers[$i];

                for ($j=0;$j<strlen($numbers);$j++){
                    $number2=$numbers[$j];
                    
                    for ($k=0;$k<strlen($numbers);$k++){
                        $number3=$numbers[$k];

                        for ($l=0;$l<strlen($numbers);$l++){
                            $number4=$numbers[$l];

                            $try=$number1.$number2.$number3.$number4;
                            $check=hash('md5',$try);

                            if ( $check == $md5 ) {
                                $pin = $try;
                                break;  
                            }
                
                            
                            if ( $show > 0 ) {
                                print "\n$check $try";
                                $show = $show - 1;
                            }
                            $total=$total+1;
                        }     
                    }
                }
            }
            print "\nTotal cheks:";
            print "$total\n";
            $time_post=microtime(true);
            print "Elapsed time: ";
            print $time_post-$time_pre;
            print "\n";
        }
        ?>

    </pre>
    <p>PIN:<?= htmlentities($pin);?></p>
    <form method="get">
    <input type="text" name="md5" size="60" />
    <input type="submit" value="Crack MD5"/>
    </form> 

</body>
</html>