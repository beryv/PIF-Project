<?php
//if user not logged send to login
if(!isset($_SESSION["ConState"]) || $_SESSION["ConState"]!=true){
    echo "<script>window.location.href = 'index.php?page=login'</script>";
    die();
}
//if user not admin send to 401-Unauthorized
if(!isset($_SESSION["type"]) || $_SESSION["type"] != "adm"){
    echo "<script>window.location.href = 'index.php?page=401'</script>";
    die();
}

echo "<div class=\"datatbl mt-5\">
<h1>Measurments</h1>
<br>
<table id=\"tbl_measures\" class=\"table table-striped table-hover\" style=\"width:100%\">
    <thead>
        <tr>
            <th># Measure</th>
            <th><i class=\"bi bi-calendar4-week\"></i> Date</th>
            <th><i class=\"bi bi-cash-stack\"></i> Price</th>
            <th><i class=\"bi bi-boxes\"></i> Weight</th>
            <th><i class=\"bi bi-recycle\"></i> Trashtyp</th>
            <th><i class=\"bi bi-buildings\"></i> Center</th>
            <th><i class=\"bi bi-pc\"></i> Station</th>
            <th><i class=\"bi bi-person\"></i> User</th>
            <th># Bill</th>
            <th><i class=\"bi bi-arrow-up-right\"></i> Action</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
<br>
<a class=\"btn customBtn btn-green\" href=\"index.php?page=admin\"><i class=\"bi bi-arrow-left\"></i> Back</a>
</div>";
echo "<script>var data = [];</script>";
$link = mysqli_connect(HOST,DB_USER,DB_PASSWORD,DATABASE) OR die();
$query = "SELECT * FROM TBLMEASURES
            INNER JOIN TBLSTATIONS ON FISTATIONNUM = STATIONNUM";
$result = mysqli_query($link,$query) OR die(mysqli_error($link));
if(mysqli_num_rows($result) >= 1){
while($row = mysqli_fetch_assoc($result)){
    $center = "<a class=\"mainColor\" href=\"index.php?page=center&center=".$row["FICENTERCODE"]."\">".$row["FICENTERCODE"]."</a>";
    if($row["FIBILLNUM"] == null){
        $bill = "None";
    }else{
        $bill = $row["FIBILLNUM"];
    }
    $action1 = "<button type=\"button\" value=\"".$row["IDMEASURE"]."\" class=\"btn btn-green\"><i class=\"bi bi-pencil-square\"></i></button> ";
    $action2 = "<button type=\"button\" value=\"".$row["IDMEASURE"]."\" class=\"btn btn-danger\"><i class=\"bi bi-trash-fill\"></i></button> ";
    echo "<script>
            var row = ['".$row["IDMEASURE"]."','".$row["DATE"]."','".$row["TOTALPRICE"]."','".$row["WEIGHT"]."','".$row["FITRASHCODE"]."','".$center."','".$row["FISTATIONNUM"]."','".$row["FIUSERNAME"]."','".$bill."','".$action1.$action2."'];
            data.push(row);
        </script>";
}
}
mysqli_close($link);

echo "<script>
$('#tbl_measures').DataTable( {
    info: false,
    data: data,
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
?>