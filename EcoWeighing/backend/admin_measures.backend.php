<?php
session_start();
include("../inc/db_params.inc.php");
include("../inc/functions.inc.php");
//if user not logged show 401-Unauthorized
if(!isset($_SESSION["ConState"]) || $_SESSION["ConState"]!=true){
    echo "Error: 401-Unauthorized";
    die();
}
//if user not admin show 401-Unauthorized
if(!isset($_SESSION["type"]) || $_SESSION["type"] != "adm"){
    echo "Error: 401-Unauthorized";
    die();
}
//if data not set error
if(!isset($_REQUEST["num"])){
    echo "Error: Data Missing";
    die();
}

?>