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
<h1>Trash Types</h1>
<br>
<table id=\"tbl_trash\" class=\"table table-striped table-hover\" style=\"width:100%\">
    <thead>
        <tr>
            <th><i class=\"bi bi-recycle\"></i> Code</th>
            <th><i class=\"bi bi-justify-left\"></i> Description</th>
            <th><i class=\"bi bi-cash-stack\"></i> Price</th>
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
$query = "SELECT * FROM TBLTRASHTYPE";
$result = mysqli_query($link,$query) OR die(mysqli_error($link));
if(mysqli_num_rows($result) >= 1){
    while($row = mysqli_fetch_assoc($result)){
        $action1 = "<button type=\"button\" value=\"".$row["TRASHCODE"]."\" class=\"btn btn-green edit-measure\"><i class=\"bi bi-pencil-square\"></i></button> ";
        $action2 = "<button type=\"button\" value=\"".$row["TRASHCODE"]."\" class=\"btn btn-danger delete-measure\"><i class=\"bi bi-trash-fill\"></i></button> ";
        $data_row = [$row["TRASHCODE"],$row["DESCRIPTION"],$row["PRICE"]."€",$action1.$action2];
        array_push($data,$data_row);
    }
}
mysqli_close($link);

$data = json_encode($data);
echo "<script>
$('#tbl_trash').DataTable( {
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

echo "<script src=\"js/admin_trash.js\"></script>";
echo "<div id=\"admin-trash-modal\"></div>";
?>