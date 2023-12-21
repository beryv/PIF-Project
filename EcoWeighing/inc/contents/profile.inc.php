<?php
//if user not logged send to login
if(!isset($_SESSION["ConState"]) || $_SESSION["ConState"]!=true){
    echo "<script>window.location.href = 'index.php?page=login'</script>";
    die();
}
//if data not set send to 401 - Unauthoried
if(!isset($_SESSION["username"]) || !isset($_GET["user"]) || !isset($_SESSION["type"])){
    echo "<script>window.location.href = 'index.php?page=401'</script>";
    die();
}
//user can only see its profile, admin can see all profile 
if($_SESSION["username"] == $_GET["user"] || $_SESSION["type"] == "adm"){
    $link = mysqli_connect(HOST,DB_USER,DB_PASSWORD,DATABASE) OR die();

    $username = mysqli_real_escape_string($link,$_GET["user"]);
    $query = "SELECT * FROM tblusers 
                WHERE username = '$username'
            ";
    $result = mysqli_query($link,$query) OR die(mysqli_error($link));
    //verify if exist
    if(mysqli_num_rows($result) == 1){
        //catch data
        $row = mysqli_fetch_assoc($result);
        $username = $row["USERNAME"];
        $fname = $row["FIRSTNAME"];
        $lname = $row["LASTNAME"];
        $email = $row["EMAIL"];
        $type = $row["TYPE"];
        $authcode = $row["AUTHCODE"];
        $favcenter = $row["FICENTERCODE"];

        //For Update/Modify check -> profile_modify.backend.php
        $_SESSION["usernameVerify"] = $username;
        $_SESSION["emailVerify"] = $email;

        if(isset($_GET["NewCode"])){
            $code = newCode($link);
            $query = strip_tags("UPDATE TBLUSERS
                        SET AUTHCODE = '$code'
                        WHERE USERNAME LIKE '$username'
            ");
            $result = mysqli_query($link,$query) OR die(mysqli_error($link));
            echo "<script>window.location.href = 'index.php?page=profile&user=$username'</script>";
        }
        echo "<h1 class=\"text-center mt-5 display-2 fw-semibold\">Profile</h1>";
        echo "<div class=\"profile_container\">";

        echo "<div class=\"profile_data\">
                <h1 class=\"profile_username\">$username</h1>
                <table class=\"table\">
                    <tr>
                        <td>First Name:</td>
                        <td>$fname</td>
                    </tr>
                    <tr>
                        <td>Last Name:</td>
                        <td>$lname</td>
                    </tr>
                    <tr>
                        <td>E-Mail:</td>
                        <td>$email</td>
                    </tr>
                </table>
            ";
        //Admin can't modify others Admins Accounts
        if($_SESSION["username"] == $username || $type != "adm"){
            echo "<div class=\"text-center\">";
            echo "<div class=\"btn-group\" role=\"group\">";
            echo "<button type=\"button\" class=\"btn customBtn btn-green\" data-bs-toggle=\"modal\" data-bs-target=\"#modyfyModal\">
                    <i class=\"bi bi-pencil-square\"></i>
                </button>";
            echo "<button type=\"button\" class=\"btn customBtn btn-green\" data-bs-toggle=\"modal\" data-bs-target=\"#passModal\">
                    <i class=\"bi bi-key-fill\"></i>
                </button>";
            echo "<button type=\"button\" class=\"btn customBtn btn-green\" data-bs-toggle=\"modal\" data-bs-target=\"#delUserModal\">
                    <i class=\"bi bi-trash-fill\"></i>
                </button>";
            echo "</div>";
            echo "</div>";
        }

        echo "<br><div class=\"profile_center\"><h4 style=\"color:white\">Favorite Center</h4>";
        if($favcenter == null){
            echo "<button type=\"button\" class=\"btn btn-secondary\" data-bs-toggle=\"modal\" data-bs-target=\"#favCenter\">
                    Choose
                </button>";
        }else{
            echo "<div class=\"btn-group\" role=\"group\">";
            echo "<a href=\"index.php?page=center\" class=\"btn btn-secondary\">$favcenter</a>
                <button type=\"button\" class=\"btn btn-secondary\" data-bs-toggle=\"modal\" data-bs-target=\"#favCenter\">
                    <i class=\"bi bi-arrow-repeat\"></i>
                </button>";
            echo "</div>";
        }
        echo "</div>";

        echo "</div>";

        echo "<div class=\"profile_QR\">";
        showQR($authcode);
        if($_SESSION["username"] == $username || $type != "adm"){
            echo "<div class=\"btn-group\" role=\"group\">";
            echo "<a href=\"index.php?page=profile&user=$username&NewCode\" class=\"btn btn-secondary\">New Code <i class=\"bi bi-arrow-repeat\"></i></a>";
            echo "<button type=\"button\" class=\"btn btn-secondary\" data-bs-toggle=\"modal\" data-bs-target=\"#QRModal\">
                    <i class=\"bi bi-question-circle\"></i>
                </button>";
            echo "</div>";
        }
        echo "</div>";

        echo "</div>";
        //Add all modal
        modal_tutorial_QR();
        if($_SESSION["username"] == $username || $type != "adm"){
            modal_form_modify_user($username, $email, $fname, $lname);
            modal_form_modify_password();
            modal_delete_user();
            if($favcenter == null){modal_profile_favcenter();}else{modal_profile_favcenter(true);}
        }
    }
    else{
        echo "<div class=\"alert alert-danger form-alert\">Account dosen't exist!</div>";
    }
    mysqli_close($link);
}else{
    echo "<script>window.location.href = 'index.php?page=401'</script>";
}
?>