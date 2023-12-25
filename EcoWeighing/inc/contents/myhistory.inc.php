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

echo "<div class=\"datatbl\">
        <h1>My History - Measurments</h1>
        <table id=\"tbl_myhistory\" class=\"table table-striped table-hover\" style=\"width:100%\">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Price</th>
                    <th>Weight</th>
                    <th>Trashtyp</th>
                    <th>Center</th>
                    <th>Bill Num</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>";
echo "<script>var data = [];</script>";
$link = mysqli_connect(HOST,DB_USER,DB_PASSWORD,DATABASE) OR die();
$query = "SELECT * FROM TBLMEASURES
            INNER JOIN TBLSTATIONS ON FISTATIONNUM = STATIONNUM
            WHERE FIUSERNAME = '".$_SESSION["username"]."'";
$result = mysqli_query($link,$query) OR die(mysqli_error($link));
if(mysqli_num_rows($result) >= 1){
    while($row = mysqli_fetch_assoc($result)){
        if($row["FIBILLNUM"] == null){
            $bill = "None";
        }else{
            $bill = $row["FIBILLNUM"];
        }
        echo "<script>
                var row = ['".$row["DATE"]."','".$row["TOTALPRICE"]."€','".$row["WEIGHT"]."kg','".$row["FITRASHCODE"]."','".$row["FICENTERCODE"]."','".$bill."'];
                data.push(row);
            </script>";
    }
}else{
    
}
echo "<script>
        $('#tbl_myhistory').DataTable( {
            info: false,
            data: data,
            order: [[0, 'desc']],
            responsive: true,
            columnDefs: [
                {
                    targets: 0,
                    render: DataTable.render.date()
                }
            ]
        } );
</script>";
?>