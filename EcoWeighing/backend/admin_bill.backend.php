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

$link = mysqli_connect(HOST,DB_USER,DB_PASSWORD,DATABASE) OR die();
$billnum = mysqli_real_escape_string($link,$_REQUEST["num"]);

if(isset($_REQUEST["edit"])){
    if(!isset($_REQUEST["date"]) || !isset($_REQUEST["payed"])){
        echo json_encode(-1);
        die();
    }else{
        $date = mysqli_real_escape_string($link,$_REQUEST["date"]);
        $payed = mysqli_real_escape_string($link,$_REQUEST["payed"]);
    }

    $query = "UPDATE TBLBILL SET DATE = '$date', PAYED = '$payed'
            WHERE BILLNUM = '".$billnum."'";
    $result = mysqli_query($link,$query) OR die(mysqli_error($link));

    if (mysqli_query($link, $query)) {
        echo json_encode(true);
    } else {
        echo json_encode(-1);
    }
}  

if(isset($_REQUEST["delete"])){
    $query = "DELETE FROM TBLBILL WHERE BILLNUM = '".$billnum."'";
    $result = mysqli_query($link,$query) OR die(mysqli_error($link));

    if (mysqli_query($link, $query)) {
        echo json_encode(true);
    } else {
        echo json_encode(-1);
    }
}

mysqli_close($link);
?>