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
<h1>Accounts</h1>
<br>
<table id=\"tbl_accounts\" class=\"table table-striped table-hover\" style=\"width:100%\">
    <thead>
        <tr>
            <th><i class=\"bi bi-person\"></i> Username</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th><i class=\"bi bi-envelope\"></i> E-Mail</th>
            <th><i class=\"bi bi-star\"></i> Type</th>
            <th><i class=\"bi bi-qr-code-scan\"></i> Code</th>
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
$query = "SELECT * FROM TBLUSERS";
$result = mysqli_query($link,$query) OR die(mysqli_error($link));
if(mysqli_num_rows($result) >= 1){
while($row = mysqli_fetch_assoc($result)){
    $action = "<a class=\"btn btn-green\" href=\"index.php?page=profile&user=".$row["USERNAME"]."\"><i class=\"bi bi-eye-fill\"></i></a>";
    if($row["FICENTERCODE"] == null){
        $center = "None";
    }else{
        $center = "<a class=\"fw-medium mainColor link-offset-2 link-offset-3-hover link-underline-secondary link-underline-opacity-0 link-underline-opacity-75-hover\" href=\"index.php?page=center&center=".$row["FICENTERCODE"]."\">".$row["FICENTERCODE"]."</a>";
    }
    if($row["TYPE"] == "adm"){$type = "<span class=\"mainColor\"><i class=\"bi bi-star-fill\"></i></span> Admin";}else{$type = "User";}
    $data_row = [$row["USERNAME"],$row["FIRSTNAME"],$row["LASTNAME"],$row["EMAIL"],$type,$row["AUTHCODE"],$center,$action];
    array_push($data,$data_row);
}
}
mysqli_close($link);

$data = json_encode($data);
echo "<script>
$('#tbl_accounts').DataTable( {
    info: false,
    data: $data,
    order: [[0, 'asc']],
    responsive: true
} );
</script>";
?>