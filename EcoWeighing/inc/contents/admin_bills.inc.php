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
<h1>Bills</h1>
<br>
<table id=\"tbl_bills\" class=\"table table-striped table-hover\" style=\"width:100%\">
    <thead>
        <tr>
            <th># Num</th>
            <th><i class=\"bi bi-calendar4-week\"></i> Date</th>
            <th><i class=\"bi bi-cash-stack\"></i> Price</th>
            <th><i class=\"bi bi-person\"></i> User</th>
            <th><i class=\"bi bi-question-circle\"></i> Status</th>
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
$query = "SELECT BILLNUM,TBLBILL.DATE as DATE,sum(TOTALPRICE) as PRICE,PAYED,FIUSERNAME FROM TBLBILL
            LEFT JOIN TBLMEASURES ON FIBILLNUM = BILLNUM
            GROUP BY BILLNUM,DATE,PAYED,FIUSERNAME";
$result = mysqli_query($link,$query) OR die(mysqli_error($link));
if(mysqli_num_rows($result) >= 1){
while($row = mysqli_fetch_assoc($result)){
    $username = "<a class=\"fw-medium mainColor link-offset-2 link-offset-3-hover link-underline-secondary link-underline-opacity-0 link-underline-opacity-75-hover\" href=\"index.php?page=profile&user=".$row["FIUSERNAME"]."\">".$row["FIUSERNAME"]."</a>";
    if($row["PAYED"] == "YES"){
        $payed = "<i class=\"bi bi-check-circle-fill mainColor\"></i> Paid";
    }else{
        $payed = "<i class=\"bi bi-x-lg text-danger\"></i> Not Paid";
    }
    $action1 = "<button type=\"button\" value=\"".$row["BILLNUM"]."\" class=\"btn btn-green show-bill\"><i class=\"bi bi-eye-fill\"></i></button> ";
    $action2 = "<button type=\"button\" value=\"".$row["BILLNUM"]."\" class=\"btn btn-green edit-bill\"><i class=\"bi bi-pencil-square\"></i></button> ";
    $action3 = "<button type=\"button\" value=\"".$row["BILLNUM"]."\" class=\"btn btn-danger delete-bill\"><i class=\"bi bi-trash-fill\"></i></button> ";
    $data_row = [$row["BILLNUM"],$row["DATE"],$row["PRICE"]."€",$username,$payed,$action1.$action2.$action3];
    array_push($data,$data_row);
}
}
mysqli_close($link);

$data = json_encode($data);
echo "<script>
$('#tbl_bills').DataTable( {
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

echo "<script src=\"js/admin_bill.js\"></script>";
echo "<div id=\"admin-bill-modal\"></div>";
?>