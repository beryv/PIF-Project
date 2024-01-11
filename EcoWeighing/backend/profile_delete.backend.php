<?php
session_start();
include("../inc/db_params.inc.php");
include("../inc/functions.inc.php");
//if user not logged error
if(!isset($_SESSION["ConState"]) || $_SESSION["ConState"]!=true){
    echo "<div class=\"alert alert-danger\">Error: Not Connected</div>";
    die();
}
//if data not set error
if(!isset($_SESSION["username"]) || !isset($_SESSION["usernameVerify"]) || !isset($_SESSION["type"])){
    echo "<div class=\"alert alert-danger\">Error: Data Missing</div>";
    die();
}
//Get User type
$type = getUserType($_SESSION["usernameVerify"]);
//user can only update its profile, admin can update all profile 
if($_SESSION["username"] == $_SESSION["usernameVerify"] || ($_SESSION["type"] == "adm" && $type != "adm")){
    $link = mysqli_connect(HOST,DB_USER,DB_PASSWORD,DATABASE) OR die();

    //delete all users bills
    $query = "DELETE FROM tblbill WHERE BILLNUM IN (SELECT FIBILLNUM FROM TBLMEASURES WHERE FIUSERNAME = '".$_SESSION["usernameVerify"]."')";
    $result = mysqli_query($link,$query) OR die(mysqli_error($link));

    //delet users account (db automatically delete its measures)
    $query = "DELETE FROM tblusers WHERE USERNAME = '".$_SESSION["usernameVerify"]."'";
    $result = mysqli_query($link,$query) OR die(mysqli_error($link));
    if(mysqli_affected_rows($link) == 1){
        echo "<div class='alert alert-success'>Account succesfully Deleted!</div>";
        echo '<script>
                Swal.fire({
                    position: "top",
                    title: "Deleted!",
                    text: "Account has been deleted.",
                    icon: "success",
                    showCancelButton: false,
                    showConfirmButton: false
                });
            </script>';
        if($_SESSION["username"] != $_SESSION["usernameVerify"]){
            echo "<script>
                    setTimeout(function(){
                        window.location.href = \"index.php?page=admin_users\";
                    }, 1000);
                </script>";
        }
        else{
            echo "<script>
                    setTimeout(function(){
                        window.location.href = \"index.php?page=logout\";
                    }, 1000);
                </script>";
        }
    }else{
        echo "<div class='alert alert-danger'>An error has occured while Deleting the account!</div>";
    }
    mysqli_close($link);
}else{
    if($_SESSION["type"] == "adm" && $type == "adm"){
        echo "<div class=\"alert alert-danger\">Error: Unauthorized (User is a Administrator)</div>";
    }else{
        echo "<div class=\"alert alert-danger\">Error: Unauthorized</div>";
    }
    die();
}
?>