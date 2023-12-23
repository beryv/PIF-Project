<?php

//Forms

function form_login($username = null, $password = null){
    echo "
    <form action=\"index.php?page=login\" method=\"post\" class=\"login-form\">
        <div class=\"form-floating\">
            <input class=\"form-control\" type=\"text\" name=\"inUser\" id=\"inUser\" value=\"$username\" placeholder=\"Username\" required>
            <label for=\"inUser\">Username</label>
        </div>
        <br>
        <div class=\"form-floating\">
            <input class=\"form-control\" type=\"password\" name=\"inPass\" id=\"inPass\" value=\"$password\" placeholder=\"Password\" required>
            <label for=\"inPass\">Password</label>
        </div>
        <br>
        <a href=\"index.php?page=newuser\" class=\"btn customBtn btn-secondary\">New User</a>
        <input type=\"submit\" value=\"Login\" name=\"submit\" class=\"btn customBtn btn-green\">
    </form>
    <br>
    ";
}

function form_newuser($username = null, $email = null, $first = null, $last = null, $password = null, $password2 = null){
    echo "
    <form action=\"index.php?page=newuser\" method=\"post\" class=\"login-form\">
        <div class=\"form-floating\">
            <input class=\"form-control\" type=\"text\" maxlength=\"100\" name=\"inUser\" id=\"inUser\" value=\"$username\" placeholder=\"Username\" required>
            <label for=\"inUser\">Username</label>
        </div>
        <br>
        <div class=\"form-floating\">
            <input class=\"form-control\" type=\"email\" maxlength=\"100\" name=\"email\" id=\"email\" value=\"$email\" placeholder=\"E-Mail\" required>
            <label for=\"email\">E-Mail</label>
        </div>
        <br>
        <div class=\"input-group\">
            <div class=\"form-floating\">
                <input class=\"form-control\" type=\"text\" maxlength=\"100\" name=\"fname\" id=\"fname\" value=\"$first\" placeholder=\"First Name\" required>
                <label for=\"fname\">First Name</label>
            </div>
            <div class=\"form-floating\">
                <input class=\"form-control\" type=\"text\" maxlength=\"100\" name=\"lname\" id=\"lname\" value=\"$last\" placeholder=\"Last Name\" required>
                <label for=\"lname\">Last Name</label>
            </div>
        </div>
        <br>
        <div class=\"form-floating\">
            <input class=\"form-control\" type=\"password\" minlength=\"8\" name=\"inPass\" id=\"inPass\" value=\"$password\" placeholder=\"Password\" required>
            <label for=\"inPass\">Password</label>
            <div class=\"form-text\">Minimum 8 characters long.</div>
        </div>
        <br>
        <div class=\"form-floating\">
            <input class=\"form-control\" type=\"password\" minlength=\"8\" name=\"inPass2\" id=\"inPass2\" value=\"$password2\" placeholder=\"Confirm Password\" required>
            <label for=\"inPass2\">Confirm Password</label>
        </div>
        <br>
        <a href=\"index.php?page=login\" class=\"btn customBtn btn-secondary\">Back</a>
        <input type=\"submit\" value=\"Create\" name=\"submit\" class=\"btn customBtn btn-green\">
    </form>
    <br>
    ";
}

//modal

function modal_form_modify_user($username = null, $email = null, $first = null, $last = null){
    echo "<script src=\"./js/profile_modify.js\"></script>";
    echo "
    <div class=\"modal fade\" id=\"modyfyModal\" tabindex=\"-1\" aria-labelledby=\"modifyModalLabel\" aria-hidden=\"true\">
        <div class=\"modal-dialog\">
            <div class=\"modal-content\">
                <div class=\"modal-header\">
                    <h1 class=\"modal-title fs-5\" id=\"modifyModalLabel\">Modify Data</h1>
                    <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\" aria-label=\"Close\"></button>
                </div>
                <form action=\"#\" method=\"post\" class=\"\">
                    <div class=\"modal-body\">
                        <div id=\"modifyAlert\"></div>
                        <div class=\"form-floating\">
                            <input class=\"form-control\" type=\"text\" maxlength=\"100\" name=\"inUser\" id=\"inUser\" value=\"$username\" placeholder=\"Username\" required>
                            <label for=\"inUser\">Username</label>
                        </div>
                        <br>
                        <div class=\"form-floating\">
                            <input class=\"form-control\" type=\"email\" maxlength=\"100\" name=\"email\" id=\"email\" value=\"$email\" placeholder=\"E-Mail\" required>
                            <label for=\"email\">E-Mail</label>
                        </div>
                        <br>
                        <div class=\"input-group\">
                            <div class=\"form-floating\">
                                <input class=\"form-control\" type=\"text\" maxlength=\"100\" name=\"fname\" id=\"fname\" value=\"$first\" placeholder=\"First Name\" required>
                                <label for=\"fname\">First Name</label>
                            </div>
                            <div class=\"form-floating\">
                                <input class=\"form-control\" type=\"text\" maxlength=\"100\" name=\"lname\" id=\"lname\" value=\"$last\" placeholder=\"Last Name\" required>
                                <label for=\"lname\">Last Name</label>
                            </div>
                        </div>   
                    </div>
                    <div class=\"modal-footer\">
                        <button type=\"button\" class=\"btn btn-secondary\" data-bs-dismiss=\"modal\">Close</button>
                        <input onclick=\"save_modification()\" type=\"submit\" value=\"Save\" name=\"submit\" class=\"btn btn-green\">
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <br>
    ";
}

function modal_form_modify_password(){
    echo "<script src=\"./js/profile_modify_pass.js\"></script>";
    echo "
    <div class=\"modal fade\" id=\"passModal\" tabindex=\"-1\" aria-labelledby=\"passModalLabel\" aria-hidden=\"true\">
        <div class=\"modal-dialog\">
            <div class=\"modal-content\">
                <div class=\"modal-header\">
                    <h1 class=\"modal-title fs-5\" id=\"passModalLabel\">Change Password</h1>
                    <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\" aria-label=\"Close\"></button>
                </div>
                <form action=\"#\" method=\"post\" class=\"\">
                    <div class=\"modal-body\">
                        <div id=\"passAlert\"></div>
                        <div class=\"form-floating\">
                            <input class=\"form-control\" type=\"password\" name=\"inPassC\" id=\"inPassC\" value=\"\" placeholder=\"Current Password\" required>
                            <label for=\"inPassC\">Current Password</label>
                        </div>
                        <br>
                        <div class=\"form-floating\">
                            <input class=\"form-control\" type=\"password\" minlength=\"8\" name=\"inPass\" id=\"inPass\" value=\"\" placeholder=\"New Password\" required>
                            <label for=\"inPass\">New Password</label>
                            <div class=\"form-text\">Minimum 8 characters long.</div>
                        </div>
                        <br>
                        <div class=\"form-floating\">
                            <input class=\"form-control\" type=\"password\" minlength=\"8\" name=\"inPass2\" id=\"inPass2\" value=\"\" placeholder=\"Confirm Password\" required>
                            <label for=\"inPass2\">Confirm Password</label>
                        </div>
                    </div>
                    <div class=\"modal-footer\">
                        <button type=\"button\" class=\"btn btn-secondary\" data-bs-dismiss=\"modal\">Close</button>
                        <input onclick=\"save_new_password()\" type=\"submit\" value=\"Save\" name=\"submit\" class=\"btn btn-green\">
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <br>
    ";
}

function modal_delete_user(){
    echo "<script src=\"./js/profile_delete.js\"></script>";
    echo "
    <div class=\"modal fade\" id=\"delUserModal\" tabindex=\"-1\" aria-labelledby=\"delUserModalLabel\" aria-hidden=\"true\">
        <div class=\"modal-dialog\">
            <div class=\"modal-content\">
                <div class=\"modal-header\">
                    <h1 class=\"modal-title fs-5\" id=\"delUserModalLabel\">Delete Account</h1>
                    <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\" aria-label=\"Close\"></button>
                </div>
                <form action=\"#\" method=\"post\" class=\"\">
                    <div class=\"modal-body\">
                        <div id=\"deleteAlert\"></div>
                            Do you really want to delete this Account ?
                    </div>
                    <div class=\"modal-footer\">
                        <button type=\"button\" class=\"btn btn-secondary\" data-bs-dismiss=\"modal\">Close</button>
                        <input onclick=\"delete_accoutn()\" type=\"submit\" value=\"Confirm\" name=\"submit\" class=\"btn btn-danger\">
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <br>
    ";
}

function modal_profile_favcenter($showReset=false){
    echo "<script src=\"./js/profile_favcenter.js\"></script>";
    echo "
    <div class=\"modal fade\" id=\"favCenter\" tabindex=\"-1\" aria-labelledby=\"favCenterLabel\" aria-hidden=\"true\">
        <div class=\"modal-dialog\">
            <div class=\"modal-content\">
                <div class=\"modal-header\">
                    <h1 class=\"modal-title fs-5\" id=\"favCenterLabel\">Select a Favorite Center</h1>
                    <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\" aria-label=\"Close\"></button>
                </div>
                    <div class=\"modal-body\">
                        <div class=\"input-group mb-3\">
                            <div id=\"favcenterAlert\"></div>
                            <input class=\"form-control\" type=\"text\" name=\"centerSearch\" id=\"centerSearch\" value=\"\" placeholder=\"Search\">
                            <label class=\"input-group-text\" for=\"centerSearch\"><i class=\"bi bi-search\"></i></label>
                        </div>
                        <div class=\"list-group\" id=\"centerSearchResult\">
                        </div>
                    </div>
                    <div class=\"modal-footer\">
                        <button type=\"button\" class=\"btn btn-secondary\" data-bs-dismiss=\"modal\">Close</button>
                        "; if($showReset == true){echo "<button type=\"button\" class=\"btn btn-warning\" id=\"favCenterReset\">Reset</button>";} echo "
                    </div>
            </div>
        </div>
    </div>
    
    <br>
    ";
}

function modal_tutorial_QR(){
    echo "
    <div class=\"modal fade\" id=\"QRModal\" tabindex=\"-1\" aria-labelledby=\"QRModalLabel\" aria-hidden=\"true\">
        <div class=\"modal-dialog\">
            <div class=\"modal-content\">
                <div class=\"modal-header\">
                    <h1 class=\"modal-title fs-5\" id=\"QRModalLabel\">How to Generate a QR-Code</h1>
                    <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\" aria-label=\"Close\"></button>
                </div>
                    <div class=\"modal-body\">
                        <h4>Step - 1</h4>
                        Copy the code showed on your Profile
                        <h4>Step - 2</h4>
                        Go on a QR-code Generator site<br>
                        Like: <a href=\"https://qr.io/?gad_source=1&gclid=EAIaIQobChMIjd2NkIGAgwMVDJSDBx3XGgOhEAAYAyAAEgJS7vD_BwE\">Click</a>
                        <h4>Step - 3</h4>
                        Generate your QR-Code and use it to gain access to the Recycling Centers
                    </div>
                    <div class=\"modal-footer\">
                        <button type=\"button\" class=\"btn btn-secondary\" data-bs-dismiss=\"modal\">Close</button>
                    </div>
            </div>
        </div>
    </div>
    
    <br>
    ";
}

function modal_center_select(){
    echo "<script src=\"./js/center_search.js\"></script>";
    echo "
    <div class=\"modal fade\" id=\"selCenter\" tabindex=\"-1\" aria-labelledby=\"selCenterLabel\" aria-hidden=\"true\">
        <div class=\"modal-dialog\">
            <div class=\"modal-content\">
                <div class=\"modal-header\">
                    <h1 class=\"modal-title fs-5\" id=\"selCenterLabel\">Select a Center</h1>
                    <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\" aria-label=\"Close\"></button>
                </div>
                    <div class=\"modal-body\">
                        <div class=\"input-group mb-3\">
                            <input class=\"form-control\" type=\"text\" name=\"centerSearch\" id=\"centerSearch\" value=\"\" placeholder=\"Search\">
                            <label class=\"input-group-text\" for=\"centerSearch\"><i class=\"bi bi-search\"></i></label>
                        </div>
                        <div class=\"list-group\" id=\"centerSearchResult\">
                        </div>
                    </div>
                    <div class=\"modal-footer\">
                        <button type=\"button\" class=\"btn btn-secondary\" data-bs-dismiss=\"modal\">Close</button>
                    </div>
            </div>
        </div>
    </div>
    
    <br>
    ";
}


//Availability Check

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
        echo "<div class=\"text-center mt-4\"><button type=\"button\" class=\"btn customBtn btn-green\" data-bs-toggle=\"modal\" data-bs-target=\"#selCenter\">
                    Change <i class=\"bi bi-arrow-repeat\"></i>
                </button></div>";
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