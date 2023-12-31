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
if(!isset($_SESSION["username"]) || !isset($_SESSION["usernameVerify"]) || !isset($_SESSION["type"]) || !isset($_GET["centercode"])){
    echo "<div class=\"alert alert-danger\">Error: Data Missing</div>";
    die();
}

//if fav on center page
if(isset($_GET["fromCenter"])){
    $link = mysqli_connect(HOST,DB_USER,DB_PASSWORD,DATABASE) OR die();

    $centercode = mysqli_real_escape_string($link,$_GET["centercode"]);

    if(!empty($centercode)){
        if($centercode == "null"){
            $query = strip_tags("UPDATE tblusers 
            SET FICENTERCODE = NULL
            WHERE USERNAME = '".$_SESSION["username"]."'");
        }else{
            $query = strip_tags("UPDATE tblusers 
            SET FICENTERCODE = '$centercode'
            WHERE USERNAME = '".$_SESSION["username"]."'");
        }
        
        $result = mysqli_query($link,$query) OR die(mysqli_error($link));
        if(mysqli_affected_rows($link) == 1){
            $_SESSION["favcenter"] = $centercode;
            echo "<div class='alert alert-success'>Favorite Center succesfully Updated!</div>";
            echo "<script>window.location.href = 'index.php?page=center'</script>";
        }else{
            echo "<div class='alert alert-danger'>Error while updating Favorite Center</div>";
        }
    }
    else{
        echo "<div class=\"alert alert-danger\">Center Code is Missing</div>";
        die();
    }
    mysqli_close($link);
    die();
}

//Get User type
$type = getUserType($_SESSION["usernameVerify"]);
//(fav on profile page) user can only update its profile, admin can update all profile
if($_SESSION["username"] == $_SESSION["usernameVerify"] || ($_SESSION["type"] == "adm" && $type != "adm")){
    $link = mysqli_connect(HOST,DB_USER,DB_PASSWORD,DATABASE) OR die();

    $centercode = mysqli_real_escape_string($link,$_GET["centercode"]);

    if(!empty($centercode)){
        if($centercode == "null"){
            $query = strip_tags("UPDATE tblusers 
            SET FICENTERCODE = NULL
            WHERE USERNAME = '".$_SESSION["usernameVerify"]."'");
        }else{
            $query = strip_tags("UPDATE tblusers 
            SET FICENTERCODE = '$centercode'
            WHERE USERNAME = '".$_SESSION["usernameVerify"]."'");
        }
        
        $result = mysqli_query($link,$query) OR die(mysqli_error($link));
        if(mysqli_affected_rows($link) == 1){
            $_SESSION["favcenter"] = $centercode;
            echo "<div class='alert alert-success'>Favorite Center succesfully Updated!</div>";
            echo "<script>window.location.href = 'index.php?page=profile&user=".$_SESSION["usernameVerify"]."'</script>";
        }else{
            echo "<div class='alert alert-danger'>Error while updating Favorite Center</div>";
            die();
        }
    }
    else{
        echo "<div class=\"alert alert-danger\">Center Code is Missing</div>";
        die();
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