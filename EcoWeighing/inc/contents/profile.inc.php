<?php
//if user not logged send to login
if(!isset($_SESSION["ConState"]) || $_SESSION["ConState"]!=true){
    echo "<script>window.location.href = 'index.php?page=login'</script>";
}
//if data not set send to 401 - Unauthoried
if(!isset($_SESSION["username"]) || !isset($_GET["user"]) || !isset($_SESSION["type"])){
    echo "<script>window.location.href = 'index.php?page=401'</script>";
}
//user can only see its profile, admin can see all profile 
if($_SESSION["username"] == $_GET["user"] || $_SESSION["type"] == "adm"){
    $link = mysqli_connect(HOST,DB_USER,DB_PASSWORD,DATABASE) OR die();

    $username = $_GET["user"];
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
        
        echo "<div>
                <h1>$username</h1>
                <p>$fname</p>
                <p>$lname</p>
                <p>$email</p>
            </div>";
        echo "<div><p>fav center: ";
        if($favcenter == null){
            echo "None</p>";
        }else{
            echo "$favcenter</p>";
        }
        echo "</div>";
        echo "<div>
                <script src=\"https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js\"></script>
                <div id=\"qrcode\"></div>
                <script type=\"text/javascript\">
                    new QRCode(document.getElementById(\"qrcode\"), \"$authcode\");
                </script>
                <p>$authcode</p>
            </div>";
    }
    else{
        echo "<div class=\"alert alert-danger\">Account dosen't exist!</div>";
    }
    mysqli_close($link);
}else{
    echo "<script>window.location.href = 'index.php?page=401'</script>";
}
?>