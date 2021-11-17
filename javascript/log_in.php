<?php 
session_start();
if(!isset($_SESSION['name'])){
    die('Not logged in');
}
?>