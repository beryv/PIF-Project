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
if(!isset($_REQUEST["id"])){
    echo "Error: Data Missing";
    die();
}

$link = mysqli_connect(HOST,DB_USER,DB_PASSWORD,DATABASE) OR die();
$id = mysqli_real_escape_string($link,$_REQUEST["id"]);

if(isset($_REQUEST["get"])){

    $query = "SELECT * FROM TBLMEASURES
            WHERE IDMEASURE = '".$id."'";
    $result = mysqli_query($link,$query) OR die(mysqli_error($link));
    if(mysqli_num_rows($result) >= 1){
        $row = mysqli_fetch_assoc($result);
        $data = ["weight"=>$row["WEIGHT"],"price"=>$row["TOTALPRICE"],"date"=>$row["DATE"],"user"=>$row["FIUSERNAME"],"station"=>$row["FISTATIONNUM"],"trash"=>$row["FITRASHCODE"],"bill"=>$row["FIBILLNUM"]];
    }else{
        echo json_encode(-1);
        die();
    }

    echo json_encode($data);
}

if(isset($_REQUEST["getSel"])){
    $data = ["trashtype"=>[],"station"=>[],"bill"=>[]];

    $query = "SELECT * FROM TBLTRASHTYPE";
    $result = mysqli_query($link,$query) OR die(mysqli_error($link));
    if(mysqli_num_rows($result) >= 1){
        while($row = mysqli_fetch_assoc($result)){
            array_push($data["trashtype"],$row["TRASHCODE"]);
        }
    }else{
        echo json_encode(-1);
        die();
    }

    $query = "SELECT * FROM TBLSTATIONS";
    $result = mysqli_query($link,$query) OR die(mysqli_error($link));
    if(mysqli_num_rows($result) >= 1){
        while($row = mysqli_fetch_assoc($result)){
            array_push($data["station"],$row["STATIONNUM"]);
        }
    }else{
        echo json_encode(-1);
        die();
    }

    $query = "SELECT * FROM TBLBILL";
    $result = mysqli_query($link,$query) OR die(mysqli_error($link));
    if(mysqli_num_rows($result) >= 1){
        while($row = mysqli_fetch_assoc($result)){
            array_push($data["bill"],$row["BILLNUM"]);
        }
    }else{
        echo json_encode(-1);
        die();
    }

    echo json_encode($data);
}

if(isset($_REQUEST["save"])){
    if(!isset($_REQUEST["date"]) || !isset($_REQUEST["price"]) || !isset($_REQUEST["weight"]) || !isset($_REQUEST["trash"]) || !isset($_REQUEST["station"]) || !isset($_REQUEST["user"]) || !isset($_REQUEST["bill"])){
        echo json_encode(-1);
        die();
    }else{
        $date = mysqli_real_escape_string($link,$_REQUEST["date"]);
        $price = mysqli_real_escape_string($link,$_REQUEST["price"]);
        $weight = mysqli_real_escape_string($link,$_REQUEST["weight"]);
        $trash = mysqli_real_escape_string($link,$_REQUEST["trash"]);
        $station = mysqli_real_escape_string($link,$_REQUEST["station"]);
        $user = mysqli_real_escape_string($link,$_REQUEST["user"]);
        $bill = mysqli_real_escape_string($link,$_REQUEST["bill"]);
    }

    $query = "UPDATE TBLMEASURES SET DATE = '$date', TOTALPRICE = '$price', WEIGHT = '$weight', FITRASHCODE = '$trash', FISTATIONNUM = '$station', FIUSERNAME = '$user', FIBILLNUM = '$bill'
            WHERE IDMEASURE = '".$id."'";

    if (mysqli_query($link, $query)) {
        echo json_encode(true);
    } else {
        echo json_encode(-1);
    }
}

if(isset($_REQUEST["delete"])){
    $query = "DELETE FROM TBLMEASURES WHERE IDMEASURE = '".$id."'";

    if (mysqli_query($link, $query)) {
        echo json_encode(true);
    } else {
        echo json_encode(-1);
    }
}

mysqli_close($link);
?>