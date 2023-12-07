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
if(!isset($_SESSION["username"]) || !isset($_GET["username"]) || !isset($_SESSION["type"])){
    echo "<div class=\"alert alert-danger\">Error: Data Missing</div>";
    die();
}
//user can only update its profile, admin can update all profile 
if($_SESSION["username"] == $_SESSION["usernameVerify"] || $_SESSION["type"] == "adm"){
    $link = mysqli_connect(HOST,DB_USER,DB_PASSWORD,DATABASE) OR die();

    $user = mysqli_real_escape_string($link,$_GET["username"]);
    $fname = mysqli_real_escape_string($link,$_GET["fname"]);
    $lname = mysqli_real_escape_string($link,$_GET["lname"]);
    $email = mysqli_real_escape_string($link,$_GET["email"]);

    //checks data validity
    if(!empty($user) && !empty($lname) && !empty($fname) && !empty($email)){
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            echo "<div class=\"alert alert-danger\">Email is not valid!</div>";
            die();
        }
        else if(strlen($user) >100 || strlen($lname) >100 || strlen($fname) >100 || strlen($email) >100){
            echo "<div class=\"alert alert-danger\">Some Inputs are too long! (max 100)</div>";
            die();
        }
        else{
            //Insert User in Database when Username und Email are Unique
            if((checkUsername($user,$link)==true && checkemail($email,$link)==true) || ($user == $_SESSION["usernameVerify"] && $email == $_SESSION["emailVerify"]) || (checkUsername($user,$link)==true && $email == $_SESSION["emailVerify"]) || ($user == $_SESSION["usernameVerify"] && checkemail($email,$link)==true)){
                $query = strip_tags("UPDATE IGNORE tblusers 
                SET EMAIL = '$email', FIRSTNAME = '$fname', LASTNAME = '$lname', USERNAME = '$user'
                WHERE USERNAME = '".$_SESSION["usernameVerify"]."'");

                $result = mysqli_query($link,$query) OR die(mysqli_error($link));
                if(mysqli_affected_rows($link) >= 1){
                    if($_SESSION["username"] != $user && $_SESSION["usernameVerify"] == $_SESSION["username"]){
                        $_SESSION["username"]= $user;
                        $_SESSION["firstname"] = $fname;
                        $_SESSION["lastname"] = $lname;
                        $_SESSION["email"] = $email;
                    }
                    unset($_SESSION["usernameVerify"]);
                    unset($_SESSION["emailVerify"]);
                    echo "<div class='alert alert-success'>Account succesfully Edited!</div>";
                    echo "<script>window.location.href = 'index.php?page=profile&user=$user'</script>";
                }else{
                    echo "<div class='alert alert-danger'>An error has occured while editing the account!</div>";
                    die();
                }
            }
            else{
                if(checkUsername($user,$link)==false && $user != $_SESSION["usernameVerify"]){
                    echo "<div class='alert alert-danger '>Username is alredy being used, choose another one!</div>";
                }else if(checkEmail($email,$link)==false){
                    echo "<div class='alert alert-danger'>Email is alredy being used, choose another one!</div>";
                }
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