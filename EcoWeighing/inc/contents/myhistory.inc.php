<?php
//if user not logged send to login
if(!isset($_SESSION["ConState"]) || $_SESSION["ConState"]!=true){
    echo "<script>window.location.href = 'index.php?page=login'</script>";
    die();
}
//if data not set send to 401 - Unauthoried
if(!isset($_SESSION["username"])){
    echo "<script>window.location.href = 'index.php?page=401'</script>";
    die();
}

echo "<h1>My History</h1>";
$link = mysqli_connect(HOST,DB_USER,DB_PASSWORD,DATABASE) OR die();
$query = "SELECT * FROM TBLMEASURES
            INNER JOIN TBLSTATIONS ON FISTATIONNUM = STATIONNUM
            WHERE FIUSERNAME = '".$_SESSION["username"]."'";
$result = mysqli_query($link,$query) OR die(mysqli_error($link));
echo "<table class=\"table\">
            <tr>
                <th>Date</th>
                <th>Price</th>
                <th>Weight</th>
                <th>Trashtyp</th>
                <th>Center</th>
                <th>Bill Num</th>
            </tr>";
if(mysqli_num_rows($result) >= 1){
    while($row = mysqli_fetch_assoc($result)){
        echo "<tr>";
        echo "<td>".$row["DATE"]."</td><td>".$row["TOTALPRICE"]."€</td><td>".$row["WEIGHT"]."kg</td><td>".$row["FITRASHCODE"]."</td><td>".$row["FICENTERCODE"]."</td>";
        if($row["FIBILLNUM"] == null){
            echo "<td>None</td>";
        }else{
            echo "<td>".$row["FIBILLNUM"]."</td>";
        }
    }
}else{
    echo "<td colspan=\"6\" class=\"text-center\">Nothing Found</td>";
}
echo "</tr></table>";

?>