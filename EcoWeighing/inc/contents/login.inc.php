<?php
    //if connected send to profile
    if(isset($_SESSION["ConState"]) && $_SESSION["ConState"]==true){
        echo "<script>window.location.href = 'index.php?page=profile&user=".$_SESSION["username"]."'</script>";
        die();
    }

    echo "<br><div class=\"text-center\" style=\"margin-top:5%;\">
                <h1 class=\"logo\">ECOWEIGHING</h1>
                <h2>Sign in</h2>
            </div><br>";
    
    if(isset($_POST["submit"])){
        
        $user = $_POST["inUser"];
        $pass = $_POST["inPass"];

        //check if user exist and input validity
        if(!empty($user) && !empty($pass)){

            $link = mysqli_connect(HOST,DB_USER,DB_PASSWORD,DATABASE) OR die();

            $user = mysqli_real_escape_string($link,$user);
            $pass = mysqli_real_escape_string($link,$pass);
            $pass = hash("sha256",$pass);
            
            
            $query = "SELECT * FROM tblusers WHERE USERNAME = '$user' AND PASSWORD = '$pass'";
            $result = mysqli_query($link,$query) OR die(mysqli_error($link));
            if(mysqli_num_rows($result) >= 1){

                while($row = mysqli_fetch_assoc($result)){
                    $_SESSION["username"]= $row["USERNAME"];
                    $_SESSION["firstname"] = $row["FIRSTNAME"];
                    $_SESSION["lastname"] = $row["LASTNAME"];
                    $_SESSION["email"] = $row["EMAIL"];
                    $_SESSION["type"] = $row["TYPE"];
                    $_SESSION["favcenter"] = $row["FICENTERCODE"];
                }

                $_SESSION["ConState"] = true;
                echo "<script>window.location.href = 'index.php?page=profile&user=".$_SESSION["username"]."'</script>";
            }
            else{
                echo "<div class=\"alert alert-danger form-alert\">Username or Password is Incorrect!</div>";
                form_login($user);
            }
            mysqli_close($link);
        }else{
            echo "<div class=\"alert alert-danger form-alert\" role=\"alert\">Username and Password is Required!</div>";
            form_login($user);
        }
    }else{
        form_login();
    }
?>