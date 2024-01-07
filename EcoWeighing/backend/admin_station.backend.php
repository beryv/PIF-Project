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
$num = mysqli_real_escape_string($link,$_REQUEST["num"]);

if(isset($_REQUEST["getTrash"])){
    $data = ["all"=>[],"current"=>[]];

    $query = "SELECT * FROM TBLTRASHTYPE";
    $result = mysqli_query($link,$query) OR die(mysqli_error($link));
    if(mysqli_num_rows($result) >= 1){
        while($row = mysqli_fetch_assoc($result)){
            array_push($data["all"],$row["TRASHCODE"]);
        }
    }

    $query = "SELECT FITRASHCODE FROM TBLSTATIONSTYPE
                WHERE FISTATIONNUM = '$num'";
    $result = mysqli_query($link,$query) OR die(mysqli_error($link));
    if(mysqli_num_rows($result) >= 1){
        while($row = mysqli_fetch_assoc($result)){
            array_push($data["current"],$row["FITRASHCODE"]);
        }
    }

    echo json_encode($data);
}

if(isset($_REQUEST["delTrash"]) && isset($_REQUEST["trash"])){
    $trash = mysqli_real_escape_string($link,$_REQUEST["trash"]);

    $query = "DELETE FROM TBLSTATIONSTYPE WHERE FISTATIONNUM = '".$num."'
                AND FITRASHCODE = '".$trash."'";

    if (mysqli_query($link, $query)) {
        echo json_encode(true);
    } else {
        echo json_encode(-1);
    }
}

if(isset($_REQUEST["newTrash"]) && isset($_REQUEST["trash"])){
    $trash = mysqli_real_escape_string($link,$_REQUEST["trash"]);

    $query = "INSERT INTO TBLSTATIONSTYPE (FISTATIONNUM, FITRASHCODE)
                VALUES ('$num', '$trash')";

    if (mysqli_query($link, $query)) {
        echo json_encode(true);
    } else {
        echo json_encode(-1);
    }
}

if(isset($_REQUEST["getCenter"])){

    $data = [];

    $query = "SELECT * FROM TBLCENTERS";
    $result = mysqli_query($link,$query) OR die(mysqli_error($link));
    if(mysqli_num_rows($result) >= 1){
        while($row = mysqli_fetch_assoc($result)){
            array_push($data,$row["CENTERCODE"]);
        }
    }else{
        echo json_encode(-1);
    }

    echo json_encode($data);
}

if(isset($_REQUEST["get"])){

    $query = "SELECT * FROM TBLSTATIONS
            WHERE STATIONNUM = '".$num."'";
    $result = mysqli_query($link,$query) OR die(mysqli_error($link));
    if(mysqli_num_rows($result) >= 1){
        $row = mysqli_fetch_assoc($result);
        $data = ["desc"=>$row["DESCRIPTION"],"center"=>$row["FICENTERCODE"]];
    }else{
        echo json_encode(-1);
    }

    echo json_encode($data);
}

if(isset($_REQUEST["new"])){
    if(!isset($_REQUEST["desc"]) || !isset($_REQUEST["center"])){
        echo json_encode(-1);
        die();
    }else{
        $desc = mysqli_real_escape_string($link,$_REQUEST["desc"]);
        $center = mysqli_real_escape_string($link,$_REQUEST["center"]);
    }

    $query = "INSERT INTO TBLSTATIONS (DESCRIPTION, FICENTERCODE)
                VALUES ('$desc','$center')";

    if (mysqli_query($link, $query)) {
        echo json_encode(true);
    } else {
        echo json_encode(-1);
    }
}

if(isset($_REQUEST["save"])){
    if(!isset($_REQUEST["desc"]) || !isset($_REQUEST["center"])){
        echo json_encode(-1);
        die();
    }else{
        $desc = mysqli_real_escape_string($link,$_REQUEST["desc"]);
        $center = mysqli_real_escape_string($link,$_REQUEST["center"]);
    }

    $query = "UPDATE TBLSTATIONS SET DESCRIPTION = '$desc', FICENTERCODE = '$center'
                WHERE STATIONNUM = '".$num."'";

    if (mysqli_query($link, $query)) {
        echo json_encode(true);
    } else {
        echo json_encode(-1);
    }
}

if(isset($_REQUEST["delete"])){
    $query = "DELETE FROM TBLSTATIONS WHERE STATIONNUM = '".$num."'";

    if (mysqli_query($link, $query)) {
        echo json_encode(true);
    } else {
        echo json_encode(-1);
    }
}

mysqli_close($link);
?>