<?php

//Availability Checks

function checkUsername($username,$link){
    $query = "SELECT * FROM tblusers WHERE USERNAME = '$username'";
    $result = mysqli_query($link,$query) OR die(mysqli_error($link));
    if(mysqli_num_rows($result) == 0){
        return true;
    }
    else{
        return false;
    }
}

function checkEmail($email,$link){
    $query = "SELECT * FROM tblusers WHERE EMAIL = '$email'";
    $result = mysqli_query($link,$query) OR die(mysqli_error($link));
    if(mysqli_num_rows($result) == 0){
        return true;
    }
    else{
        return false;
    }
}

//Unique AlphaNumeric Code Generator

function newCode($link){
    $allowed_characters = "0123456789abcdefghijklmnopqrstuvwxyz";
    $code = substr(str_shuffle($allowed_characters), 0, 10);
    $query = "SELECT * FROM tblusers WHERE AUTHCODE = '$code'";
    $result = mysqli_query($link,$query) OR die(mysqli_error($link));
    if(mysqli_num_rows($result) == 0){
        return $code;
    }
    else{
        return newCode($link);
    }
}

//QR-Code generation

function showQR($code){
    echo "<div>
            <script src=\"https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js\"></script>
            <div id=\"qrcode\"></div>
            <script type=\"text/javascript\">
                new QRCode(document.getElementById(\"qrcode\"), {text: \"$code\", colorDark: \"#ffffff\", colorLight : \"#94dd26\"});
            </script>
            <h3 class=\"mt-2\" style=\"display: inline-block;\">
                $code
            </h3>
        </div>";
}

//function to get users account type

function getUserType($username){
    $link = mysqli_connect(HOST,DB_USER,DB_PASSWORD,DATABASE) OR die();
    $query = "SELECT TYPE FROM tblusers
                WHERE USERNAME = '$username'
            ";
    $result = mysqli_query($link,$query) OR die(mysqli_error($link));
    if(mysqli_num_rows($result) >= 1){
        $row = mysqli_fetch_assoc($result);
        $type = $row["TYPE"];
        return $type;
    }else{
        return false;
    }
    mysqli_close($link);
}

//function that shows center data

function showCenter($center = null){
    $link = mysqli_connect(HOST,DB_USER,DB_PASSWORD,DATABASE) OR die();
    if($center == null){
        $query = "SELECT * FROM tblcenters ORDER BY RAND() LIMIT 1";
    }else{
        $query = "SELECT * FROM tblcenters WHERE CENTERCODE = '$center'";
    }
    $result = mysqli_query($link,$query) OR die(mysqli_error($link));
    if(mysqli_num_rows($result) == 1){
        $row = mysqli_fetch_assoc($result);
        echo "<div class=\"center_container\">";
        echo "<div class=\"center_data\">";
        echo "<h1 class=\"text-center\">Recycling Center<br>".$row["CENTERCODE"]." - ".$row["CITY"]."</h1>";
        getSchedules($row["CENTERCODE"]);
        echo "<div class=\"text-center mt-4\">
                <button type=\"button\" class=\"btn customBtn btn-green\" data-bs-toggle=\"modal\" data-bs-target=\"#selCenter\">
                    Change <i class=\"bi bi-arrow-repeat\"></i>
                </button> ";
        if(isset($_SESSION["ConState"]) && $_SESSION["ConState"]==true && isset($_SESSION["favcenter"]) && $_SESSION["favcenter"] == $row["CENTERCODE"]){
            echo "<button id=\"UnFavCenter\" type=\"button\" class=\"btn customBtn btn-green\">
                    <i class=\"bi bi-heart-fill\"></i>
                </button>";
            echo "<script src=\"js/center_fav.js\"></script>";
        }else if(isset($_SESSION["ConState"]) && $_SESSION["ConState"]==true){
            echo "<button id=\"FavCenter\" value=\"".$row["CENTERCODE"]."\" type=\"button\" class=\"btn customBtn btn-green\">
                    <i class=\"bi bi-heart\"></i>
                </button>";
            echo "<script src=\"js/center_fav.js\"></script>";
        }else{}
        echo "</div>";
        modal_center_select();
        echo "</div>";
        $fulladr = $row["ADRESS"].", ".$row["POSTCODE"]." ".$row["CITY"].", LU";
        showMap($fulladr);
        echo "</div>";
    }else{
        echo "<div class=\"alert alert-danger form-alert\">No Center Found</div>";
    }
    mysqli_close($link);
}

//function that get Schedules from a center

function getSchedules($center){
    if($center == null){die();}
    $days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
    $link = mysqli_connect(HOST,DB_USER,DB_PASSWORD,DATABASE) OR die();
    echo "<div class=\"tblschedules mt-4\"><table class=\"table\">";
    foreach($days as $day){
        $query = "SELECT * FROM tblschedules 
                    WHERE FICENTERCODE = '$center' 
                    AND WEEKDAY = '$day'
                    ORDER BY STARTTIME ASC";
        $result = mysqli_query($link,$query) OR die(mysqli_error($link));
        echo "<tr><th scope=\"row\">$day:</th><td>";
        if(mysqli_num_rows($result) >= 1){
            while($row = mysqli_fetch_assoc($result)){
            echo str_replace(":","h",substr($row["STARTTIME"],0,5))." - ".str_replace(":","h",substr($row["ENDTIME"],0,5))."<br>";
            }
        }else{
            echo "Closed";
        }
        echo "</td></tr>";
    }
    echo "</table></div>";
    mysqli_close($link);
}

//function that show a map of the input adress

function showMap($address){
    if($address == null){die();}
    echo "<div class=\"center_map_container\">";
    echo "<div class=\"center_map\" id=\"map\"></div>";
    echo "<h3 class=\"text-center mt-4\">$address</h3>";
    echo "</div>";
    echo "<script>
    var map = L.map('map').setView([0, 0], 10);

    // Add a map layer (e.g., OpenStreetMap)
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Use Nominatim to geocode the address to GPS coordinates
    var apiUrl = 'https://nominatim.openstreetmap.org/search?format=json&limit=1&q=' + encodeURIComponent('$address');

    fetch(apiUrl)
        .then(response => response.json())
        .then(data => {
            if (data.length > 0) {
                var location = data[0];
                var latitude = location.lat;
                var longitude = location.lon;

                // Add a marker at the geocoded location
                L.marker([latitude, longitude]).addTo(map)
                .bindPopup('Address: ' + '$address');

                // Center the map on the geocoded location
                map.setView([latitude, longitude], 17);
            } else {
                console.error('No results found for the provided address.');
            }
        })
        .catch(error => console.error('Error during Nominatim request:', error));
    </script>";
}

?>