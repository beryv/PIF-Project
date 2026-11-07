<?php
$servername = "localhost";
$username = "ecoweighing";
$password = "bestproject";
$dbname = "db_ecoweighing";

if(isset($_POST["QRCodeAuthenticate"])){
    
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    $code = mysqli_real_escape_string($conn, $_POST["QRCodeAuthenticate"]);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT USERNAME FROM TBLUSERS WHERE AUTHCODE = '$code'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        echo "access granted";
    } else {
        echo "User Not Found!";
    }

    mysqli_close($conn);
}elseif(isset($_POST["QRCodeMeasure"]) && isset($_POST["hostname"]) && isset($_POST["measuredValue"])){
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    $code = mysqli_real_escape_string($conn, $_POST["QRCodeMeasure"]);
    $stationid = mysqli_real_escape_string($conn, $_POST["hostname"]);
    $value = (float) mysqli_real_escape_string($conn, $_POST["measuredValue"]);
    $value = $value/1000;
    $type = "PLA";
    $date = date("Y-m-d");

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT USERNAME FROM TBLUSERS WHERE AUTHCODE = '$code'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $user = $row["USERNAME"];
    } else {
        echo "User Not Found!";
        die;
    }

    $sql = "SELECT PRICE FROM TBLTRASHTYPE WHERE TRASHCODE = '$type'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $totalprice = round($row["PRICE"]*$value,2);
    } else {
        echo "Trashtype Not Found!";
        die;
    }

    $sql = "INSERT INTO TBLMEASURES (FIUSERNAME,FISTATIONNUM,WEIGHT,DATE,TOTALPRICE,FITRASHCODE)
            VALUES('$user','$stationid','$value','$date','$totalprice','$type')";
    
    if (mysqli_query($conn, $sql)) {
        echo "Succesfull!";
      } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}else{
    echo "Failed!";
}
?>