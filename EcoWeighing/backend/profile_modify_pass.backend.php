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
//user can only update its profile, admin can update all profile 
if($_SESSION["username"] == $_SESSION["usernameVerify"] || $_SESSION["type"] == "adm"){
    $link = mysqli_connect(HOST,DB_USER,DB_PASSWORD,DATABASE) OR die();

    $curPass = mysqli_real_escape_string($link,$_GET["curPass"]);
    $pass = mysqli_real_escape_string($link,$_GET["newPass"]);
    $pass2 = mysqli_real_escape_string($link,$_GET["conPass"]);

    if(!empty($curPass) && !empty($pass) && !empty($pass2)){
        if(strlen($pass) <8){
            echo "<div class=\"alert alert-danger\">Password is too short!</div>";
            die();
        }
        else if($pass != $pass2){
            echo "<div class=\"alert alert-danger\">Confirmation Password is different!</div>";
            die();
        }else{
            $pass = hash("sha256",$pass);
            $curPass = hash("sha256",$curPass);
            $query = strip_tags("UPDATE tblusers 
                SET PASSWORD = '$pass'
                WHERE USERNAME = '".$_SESSION["usernameVerify"]."'
                AND PASSWORD = '$curPass'");

                $result = mysqli_query($link,$query) OR die(mysqli_error($link));
                if(mysqli_affected_rows($link) == 1){
                    echo "<div class='alert alert-success'>Password succesfully Updated!</div>";
                    echo "<script>window.location.href = 'index.php?page=profile&user=".$_SESSION["usernameVerify"]."'</script>";
                }else{
                    echo "<div class='alert alert-danger'>Current Password is Wrong</div>";
                    die();
                }
        }
    }
    else{
        echo "<div class=\"alert alert-danger\">Required Inputs are missing!</div>";
        die();
    }
    mysqli_close($link);
}else{
    echo "<div class=\"alert alert-danger\">Error: Unauthorized</div>";
    die();
}
?>