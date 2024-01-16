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
<div class=\"d-flex\">
        <h1 class=\"flex-grow-1\">Stations</h1>
        <div><button type=\"button\" class=\"btn customBtn btn-green add-station\"><i class=\"bi bi-plus-lg\"></i> New</button></div>
</div>
<br>
<table id=\"tbl_station\" class=\"table table-striped table-hover tblBreak\" style=\"width:100%\">
    <thead>
        <tr>
            <th># Num</th>
            <th><i class=\"bi bi-justify-left\"></i> Description</th>
            <th><i class=\"bi bi-buildings\"></i> Center</th>
            <th><i class=\"bi bi-arrow-up-right\"></i> Action</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
<br>
<a class=\"btn customBtn btn-green\" href=\"index.php?page=admin\"><i class=\"bi bi-arrow-left\"></i> Back</a>
</div>";

$data = [];

$link = mysqli_connect(HOST,DB_USER,DB_PASSWORD,DATABASE) OR die();
$query = "SELECT * FROM TBLSTATIONS";
$result = mysqli_query($link,$query) OR die(mysqli_error($link));
if(mysqli_num_rows($result) >= 1){
    while($row = mysqli_fetch_assoc($result)){
        $center = "<a class=\"fw-medium mainColor link-offset-2 link-offset-3-hover link-underline-secondary link-underline-opacity-0 link-underline-opacity-75-hover\" href=\"index.php?page=center&center=".$row["FICENTERCODE"]."\">".$row["FICENTERCODE"]."</a>";
        $action1 = "<button type=\"button\" value=\"".$row["STATIONNUM"]."\" class=\"btn btn-green edit-station\"><i class=\"bi bi-pencil-square\"></i></button> ";
        $action2 = "<button type=\"button\" value=\"".$row["STATIONNUM"]."\" class=\"btn btn-green trash-station\"><i class=\"bi bi-boxes\"></i></button> ";
        $action3 = "<button type=\"button\" value=\"".$row["STATIONNUM"]."\" class=\"btn btn-danger delete-station\"><i class=\"bi bi-trash-fill\"></i></button> ";
        $data_row = [$row["STATIONNUM"],$row["DESCRIPTION"],$center,$action1.$action2.$action3];
        array_push($data,$data_row);
    }
}
mysqli_close($link);

$data = json_encode($data);
echo "<script>
$('#tbl_station').DataTable( {
    info: false,
    data: $data,
    order: [[0, 'asc']],
    responsive: true,
    columnDefs: [
        {
            targets: 1,
            render: DataTable.render.date()
        }
    ]
} );
</script>";

echo "<script src=\"js/admin_station.js\"></script>";
echo "<div id=\"admin-station-modal\"></div>";
?>