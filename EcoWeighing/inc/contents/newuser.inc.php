<?php 
//if connected send to profile
if(isset($_SESSION["ConState"]) && $_SESSION["ConState"]==true){
    echo "<script>window.location.href = 'index.php?page=profile&user=".$_SESSION["username"]."'</script>";
}

echo "<br><h1 style=\"text-align: center\">Create an Account</h1><br>";
if(isset($_POST["submit"])){
    $link = mysqli_connect(HOST,DB_USER,DB_PASSWORD,DATABASE) OR die();

    $user = mysqli_real_escape_string($link,$_POST["inUser"]);
    $fname = mysqli_real_escape_string($link,$_POST["fname"]);
    $lname = mysqli_real_escape_string($link,$_POST["lname"]);
    $email = mysqli_real_escape_string($link,$_POST["email"]);
    $pass = mysqli_real_escape_string($link,$_POST["inPass"]);
    $pass2 = mysqli_real_escape_string($link,$_POST["inPass2"]);

    //checks data validity
    if(!empty($user) && !empty($lname) && !empty($fname) && !empty($email) && !empty($pass) && !empty($pass2)){
        if(strlen($pass) <8){
            echo "<div class=\"alert alert-danger\">Password is too short!</div>";
            form_newuser($user,$email,$lname,$fname);
        }
        else if($pass != $pass2){
            echo "<div class=\"alert alert-danger\">Confirmation Password is different!</div>";
            form_newuser($user,$email,$lname,$fname);
        }
        else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            echo "<div class=\"alert alert-danger\">Email is not valid!</div>";
            form_newuser($user,$email,$lname,$fname);
        }
        else if(strlen($user) >100 || strlen($lname) >100 || strlen($fname) >100 || strlen($email) >100){
            echo "<div class=\"alert alert-danger\">Some Inputs are too long! (max 100)</div>";
            form_newuser($user,$email,$lname,$fname);
        }
        else{
            //Insert User in Database when Username und Email are Unique
            if(checkUsername($user,$link)==true && checkemail($email,$link)==true){
                $code = newCode($link);
                $pass = hash("sha256",$pass);
                $query = strip_tags("INSERT INTO tblusers VALUES (
                        '$user',
                        '$fname',
                        '$lname',
                        '$email',
                        default,
                        '$code',
                        '$pass',
                        default
                )");

                $result = mysqli_query($link,$query) OR die(mysqli_error($link));
                if($result){
                    echo "<div class='alert alert-success'>Account succesfully created!</div>";
                    echo "<script>window.location.href = 'index.php?page=login'</script>";
                }else{
                    echo "<div class='alert alert-danger'>An error has occured while creating the account!</div>";
                    form_newuser();
                }
            }
            else{
                if(checkUsername($user,$link)==false){
                    echo "<div class='alert alert-danger'>Username is alredy being used, choose another one!</div>";
                }else if(checkEmail($email,$link)==false){
                    echo "<div class='alert alert-danger'>Email is alredy being used, choose another one!</div>";
                }
                form_newuser($user,$email,$lname,$fname);
            }
        }
    }
    else{
        echo "<div class=\"alert alert-danger\">Required Inputs are missing!</div>";
        form_newuser($user,$email,$lname,$fname);
    }
    mysqli_close($link);
}
else{
    form_newuser();
}
?>