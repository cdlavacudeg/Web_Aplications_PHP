<?php
//util.php
function flashMessages(){
    if ( isset($_SESSION['success']) ) {
        echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
        unset($_SESSION['success']);
    }

    if ( isset($_SESSION['error']) ) {
        echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
        unset($_SESSION['error']);
    }
}
//utility code

function validateProfile(){
    if(strlen($_POST['first_name'])  == 0 || strlen($_POST['last_name']) == 0 || strlen($_POST['email']) == 0 || strlen($_POST['headline']) == 0 || strlen($_POST['summary']) == 0){
        return "All fields are required";
    }

    if(!str_contains($_POST['email'],'@')){
            return "Email address must contain @";
        }
    return true;
}

//validate position

function validatePos(){
    for($i=0;$i<=9;$i++){
        if(!isset($_POST['year'.$i]) )continue;
        if(!isset($_POST['desc'.$i]) )continue;
        $year =$_POST['year'.$i];
        $desc = $_POST['desc'.$i];

        if(strlen($year)==0 || strlen($desc)==0){
            return"All fields are required";
        }

        if(! is_numeric($year)){
            return "Position year must be numeric";        
        }

    }
    return true;
}

//profile select

function selectProfile($pdo){
    $stmt = $pdo->prepare("SELECT user_id,profile_id,first_name, last_name, email, headline, summary FROM profile WHERE profile_id=:pid");
    $stmt->execute(array(
        ':pid' => htmlentities($_GET['profile_id']))
    );
    $profile=$stmt->fetch();
    return $profile;
}

function selectPos($pdo,$profile_id){
    $stmt=$pdo->prepare('SELECT * FROM Position WHERE profile_id= :pid ORDER BY rank');
    $stmt->execute(array(':pid'=>$profile_id));
    $position=$stmt->fetchAll(PDO::FETCH_ASSOC);
    return $position;
}

function addPos($profile_id,$pdo){
    $rank=1;
    for($i=0;$i<=9;$i++){
        if(!isset($_POST['year'.$i]) )continue;
        if(!isset($_POST['desc'.$i]) )continue;
        $year =$_POST['year'.$i];
        $desc = $_POST['desc'.$i];
        
        $stmt=$pdo->prepare('INSERT INTO Position (profile_id,rank,year,description) VALUES (:pid, :rank, :year, :desc)');
        $stmt->execute(array(
            ':pid' => $profile_id,
            ':rank' => $rank,
            ':year' => $year,
            ':desc' => $desc)
        );
        $rank++;
    }
}
