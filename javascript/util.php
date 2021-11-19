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

//profile select

function selectProfile($pdo){
    $stmt = $pdo->prepare("SELECT user_id,profile_id,first_name, last_name, email, headline, summary FROM profile WHERE profile_id=:pid");
    $stmt->execute(array(
        ':pid' => htmlentities($_GET['profile_id']))
    );
    $profile=$stmt->fetch();
    return $profile;
}
