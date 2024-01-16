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
        <h1 class=\"flex-grow-1\">Centers</h1>
        <div><button type=\"button\" class=\"btn customBtn btn-green add-center\"><i class=\"bi bi-plus-lg\"></i> New</button></div>
</div>
<br>
<table id=\"tbl_center\" class=\"table table-striped table-hover\" style=\"width:100%\">
    <thead>
        <tr>
            <th><i class=\"bi bi-buildings\"></i> Code</th>
            <th><i class=\"bi bi-signpost-2\"></i> Address</th>
            <th>Postal Code</th>
            <th><i class=\"bi bi-building\"></i> City</th>
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
$query = "SELECT * FROM TBLCENTERS";
$result = mysqli_query($link,$query) OR die(mysqli_error($link));
if(mysqli_num_rows($result) >= 1){
    while($row = mysqli_fetch_assoc($result)){
        $center = "<a class=\"fw-medium mainColor link-offset-2 link-offset-3-hover link-underline-secondary link-underline-opacity-0 link-underline-opacity-75-hover\" href=\"index.php?page=center&center=".$row["CENTERCODE"]."\">".$row["CENTERCODE"]."</a>";
        $action1 = "<button type=\"button\" value=\"".$row["CENTERCODE"]."\" class=\"btn btn-green edit-center\"><i class=\"bi bi-pencil-square\"></i></button> ";
        $action2 = "<button type=\"button\" value=\"".$row["CENTERCODE"]."\" class=\"btn btn-green schedules-center\"><i class=\"bi bi-clock\"></i></button> ";
        $action3 = "<button type=\"button\" value=\"".$row["CENTERCODE"]."\" class=\"btn btn-danger delete-center\"><i class=\"bi bi-trash-fill\"></i></button> ";
        $data_row = [$center,$row["ADRESS"],"L-".$row["POSTCODE"],$row["CITY"],$action1.$action2.$action3];
        array_push($data,$data_row);
    }
}
mysqli_close($link);

$data = json_encode($data);
echo "<script>
$('#tbl_center').DataTable( {
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

echo "<script src=\"js/admin_center.js\"></script>";
echo "<div id=\"admin-center-modal\"></div>";
?>