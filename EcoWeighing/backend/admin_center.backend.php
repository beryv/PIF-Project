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
if(!isset($_REQUEST["code"])){
    echo "Error: Data Missing";
    die();
}

$link = mysqli_connect(HOST,DB_USER,DB_PASSWORD,DATABASE) OR die();
$code = mysqli_real_escape_string($link,$_REQUEST["code"]);

if(isset($_REQUEST["get"])){

    $query = "SELECT * FROM TBLCENTERS
            WHERE CENTERCODE = '".$code."'";
    $result = mysqli_query($link,$query) OR die(mysqli_error($link));
    if(mysqli_num_rows($result) >= 1){
        $row = mysqli_fetch_assoc($result);
        $data = ["adress"=>$row["ADRESS"],"post"=>$row["POSTCODE"],"city"=>$row["CITY"]];
    }else{
        echo json_encode(-1);
        die();
    }

    echo json_encode($data);
}

if(isset($_REQUEST["new"])){
    if(!isset($_REQUEST["adress"]) || !isset($_REQUEST["post"]) || !isset($_REQUEST["city"])){
        echo json_encode(-1);
        die();
    }else{
        $adress = mysqli_real_escape_string($link,$_REQUEST["adress"]);
        $post = mysqli_real_escape_string($link,$_REQUEST["post"]);
        $city = mysqli_real_escape_string($link,$_REQUEST["city"]);
    }

    $query = "INSERT INTO TBLCENTERS (CENTERCODE, ADRESS, POSTCODE, CITY)
                VALUES ('$code','$adress','$post','$city')";

    if (mysqli_query($link, $query)) {
        echo json_encode(true);
    } else {
        echo json_encode(-1);
    }
}

if(isset($_REQUEST["save"])){
    if(!isset($_REQUEST["newcode"]) || !isset($_REQUEST["adress"]) || !isset($_REQUEST["post"]) || !isset($_REQUEST["city"])){
        echo json_encode(-1);
        die();
    }else{
        $newcode = mysqli_real_escape_string($link,$_REQUEST["newcode"]);
        $adress = mysqli_real_escape_string($link,$_REQUEST["adress"]);
        $post = mysqli_real_escape_string($link,$_REQUEST["post"]);
        $city = mysqli_real_escape_string($link,$_REQUEST["city"]);
    }

    $query = "UPDATE TBLCENTERS SET CENTERCODE = '$newcode', ADRESS = '$adress', POSTCODE = '$post', CITY = '$city'
                WHERE CENTERCODE = '".$code."'";

    if (mysqli_query($link, $query)) {
        echo json_encode(true);
    } else {
        echo json_encode(-1);
    }
}

if(isset($_REQUEST["delete"])){
    $query = "DELETE FROM TBLCENTERS WHERE CENTERCODE = '".$code."'";

    if (mysqli_query($link, $query)) {
        echo json_encode(true);
    } else {
        echo json_encode(-1);
    }
}

mysqli_close($link);
?>