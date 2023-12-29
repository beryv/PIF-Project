<?php
session_start();
include("../inc/db_params.inc.php");
include("../inc/functions.inc.php");
//if user not logged error
if(!isset($_SESSION["ConState"]) || $_SESSION["ConState"]!=true){
    echo "Error: Not Connected";
    die();
}
//if data not set error
if(!isset($_SESSION["username"])){
    echo "Error: Data Missing";
    die();
}
//(à faire) Ajouter la réponse AJAX
?>