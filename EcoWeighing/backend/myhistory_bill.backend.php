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
if(!isset($_SESSION["username"]) || !isset($_REQUEST["num"])){
    echo "Error: Data Missing";
    die();
}

$link = mysqli_connect(HOST,DB_USER,DB_PASSWORD,DATABASE) OR die();
$billnum = mysqli_real_escape_string($link,$_REQUEST["num"]);

if(!isset($_REQUEST["pay"])){

    $data = ["bill" => [],"measures" => []];

    $query = "SELECT BILLNUM,tblbill.DATE as DATE,PAYED FROM TBLBILL
            INNER JOIN tblmeasures ON FIBILLNUM = BILLNUM
            WHERE BILLNUM = '".$billnum."'
            AND FIUSERNAME = '".$_SESSION["username"]."'";
    $result = mysqli_query($link,$query) OR die(mysqli_error($link));
    if(mysqli_num_rows($result) >= 1){
        $row = mysqli_fetch_assoc($result);
        $date = date("d/m/Y", strtotime($row["DATE"]));
        $data["bill"] = ["date"=>$date,"payed"=>$row["PAYED"]];
    }else{
        echo json_encode(-1);
        die();
    }
    
    $query = "SELECT * FROM TBLMEASURES
            WHERE FIUSERNAME = '".$_SESSION["username"]."'
            AND FIBILLNUM = '".$billnum."'
            ORDER BY DATE DESC";
    $result = mysqli_query($link,$query) OR die(mysqli_error($link));
    if(mysqli_num_rows($result) >= 1){
        while($row = mysqli_fetch_assoc($result)){
            $date = date("d/m/Y", strtotime($row["DATE"]));
            array_push($data["measures"],["id"=>$row["IDMEASURE"],"date"=>$date,"price"=>$row["TOTALPRICE"],"weight"=>$row["WEIGHT"],"typ"=>$row["FITRASHCODE"]]);
        }
    }else{
        echo json_encode(-1);
        die();
    }

    echo json_encode($data);
}else{
    $query = "UPDATE TBLBILL
            INNER JOIN tblmeasures ON FIBILLNUM = BILLNUM
            SET PAYED = 'YES'
            WHERE BILLNUM = '".$billnum."'
            AND FIUSERNAME = '".$_SESSION["username"]."'";
    $result = mysqli_query($link,$query) OR die(mysqli_error($link));
    if (mysqli_query($link, $query)) {
        echo json_encode("ok");
      } else {
        echo json_encode(-1);
      }
}
mysqli_close($link);

?>