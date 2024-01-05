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

echo "<div class=\"datatbl mt-5 d-flex\">
        <h1 class=\"flex-grow-1\">My History</h1>
        <div>
            <div class=\"btn-group\" role=\"group\">
                <a class=\"btn customBtn btn-green\" href=\"index.php?page=myhistory&history=measures\""; if(isset($_GET["history"]) && $_GET["history"] == "bills"){echo"disabled";} echo">
                    Measures
                </a>
                <a class=\"btn customBtn btn-green\" href=\"index.php?page=myhistory&history=bills\""; if(!isset($_GET["history"]) || (isset($_GET["history"]) && $_GET["history"] != "bills")){echo"disabled";} echo">
                    Bills
                </a>
            </div>
        </div>
    </div><br>";

if(isset($_GET["history"]) && $_GET["history"] == "bills"){

    echo "<div class=\"datatbl\">
        <table id=\"tbl_myhistory\" class=\"table table-striped table-hover\" style=\"width:100%\">
            <thead>
                <tr>
                    <th># Bill</th>
                    <th><i class=\"bi bi-calendar4-week\"></i> Date</th>
                    <th><i class=\"bi bi-cash-stack\"></i> Price</th>
                    <th><i class=\"bi bi-question-circle\"></i> Status</th>
                    <th><i class=\"bi bi-arrow-up-right\"></i> Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>";
    
    $data = [];

    $link = mysqli_connect(HOST,DB_USER,DB_PASSWORD,DATABASE) OR die();
    $query = "SELECT BILLNUM,TBLBILL.DATE as DATE,sum(TOTALPRICE) as PRICE,PAYED FROM TBLMEASURES
            INNER JOIN TBLBILL ON FIBILLNUM = BILLNUM
            WHERE FIUSERNAME = '".$_SESSION["username"]."'
            GROUP BY BILLNUM,DATE,PAYED";
    $result = mysqli_query($link,$query) OR die(mysqli_error($link));
    if(mysqli_num_rows($result) >= 1){
        while($row = mysqli_fetch_assoc($result)){
            if($row["PAYED"] == "YES"){
                $payed = "<i class=\"bi bi-check-circle-fill mainColor\"></i> Payed";
                $action = "<button type=\"button\" value=\"".$row["BILLNUM"]."\" class=\"btn btn-green show-bill\"><i class=\"bi bi-eye-fill\"></i></button>";
            }else{
                $payed = "<i class=\"bi bi-x-lg text-danger\"></i> Not Payed";
                $action = "<button type=\"button\" value=\"".$row["BILLNUM"]."\" class=\"btn btn-green show-bill\"><i class=\"bi bi-credit-card-fill\"></i> Pay</button>";
            }
            $data_row = [$row["BILLNUM"],$row["DATE"],$row["PRICE"]."€",$payed,$action];
            array_push($data,$data_row);
        }
    }
    mysqli_close($link);

    $data = json_encode($data);
    echo "<script>
        $('#tbl_myhistory').DataTable( {
            info: false,
            data: $data,
            order: [[1, 'desc']],
            responsive: true,
            columnDefs: [
                {
                    targets: 1,
                    render: DataTable.render.date()
                }
            ]
        } );
    </script>";

    echo "<script src=\"js/myhistory_bill.js\"></script>";
    echo "<div id=\"myhistory-modal\"></div>";

}else{
    echo "<div class=\"datatbl\">
        <table id=\"tbl_myhistory\" class=\"table table-striped table-hover\" style=\"width:100%\">
            <thead>
                <tr>
                    <th><i class=\"bi bi-calendar4-week\"></i> Date</th>
                    <th><i class=\"bi bi-cash-stack\"></i> Price</th>
                    <th><i class=\"bi bi-boxes\"></i> Weight</th>
                    <th><i class=\"bi bi-recycle\"></i> Trashtyp</th>
                    <th><i class=\"bi bi-buildings\"></i> Center</th>
                    <th># Bill</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>";
    
    $data = [];

    $link = mysqli_connect(HOST,DB_USER,DB_PASSWORD,DATABASE) OR die();
    $query = "SELECT * FROM TBLMEASURES
            LEFT JOIN TBLSTATIONS ON FISTATIONNUM = STATIONNUM
            WHERE FIUSERNAME = '".$_SESSION["username"]."'";
    $result = mysqli_query($link,$query) OR die(mysqli_error($link));
    if(mysqli_num_rows($result) >= 1){
        while($row = mysqli_fetch_assoc($result)){
            if($row["FISTATIONNUM"] == null){$center = "None";}else{$center = "<a class=\"mainColor\" href=\"index.php?page=center&center=".$row["FICENTERCODE"]."\">".$row["FICENTERCODE"]."</a>";}
            if($row["FIBILLNUM"] == null){$bill = "None";}else{$bill = $row["FIBILLNUM"];}
            if($row["FITRASHCODE"] == null){$trash = "-";}else{$trash = $row["FITRASHCODE"];}
            $data_row = [$row["DATE"],$row["TOTALPRICE"]."€",$row["WEIGHT"]."kg",$trash,$center,$bill];
            array_push($data,$data_row);
        }
    }
    mysqli_close($link);

    $data = json_encode($data);
    echo "<script>
        $('#tbl_myhistory').DataTable( {
            info: false,
            data: $data,
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
}
?>