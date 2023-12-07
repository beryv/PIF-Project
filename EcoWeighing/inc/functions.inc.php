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
    <button type=\"button\" class=\"btn btn-primary\" data-bs-toggle=\"modal\" data-bs-target=\"#modyfyModal\">
        Modify
    </button>
    <div class=\"modal fade\" id=\"modyfyModal\" tabindex=\"-1\" aria-labelledby=\"modifyModalLabel\" aria-hidden=\"true\">
        <div class=\"modal-dialog\">
            <div class=\"modal-content\">
                <div class=\"modal-header\">
                    <h1 class=\"modal-title fs-5\" id=\"modifyModalLabel\">Modify</h1>
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
    echo "
    <button type=\"button\" class=\"btn btn-primary\" data-bs-toggle=\"modal\" data-bs-target=\"#passModal\">
        Change Password
    </button>
    <div class=\"modal fade\" id=\"passModal\" tabindex=\"-1\" aria-labelledby=\"passModalLabel\" aria-hidden=\"true\">
        <div class=\"modal-dialog\">
            <div class=\"modal-content\">
                <div class=\"modal-header\">
                    <h1 class=\"modal-title fs-5\" id=\"passModalLabel\">Change Password</h1>
                    <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\" aria-label=\"Close\"></button>
                </div>
                <form action=\"#\" method=\"post\" class=\"\">
                <div class=\"modal-body\">
                    <div class=\"form-floating\">
                        <input class=\"form-control\" type=\"password\" name=\"inPassC\" id=\"inPassC\" value=\"\" placeholder=\"Current Password\" required>
                        <label for=\"inPassC\">Current Password</label>
                    </div>
                    <br>
                    <div class=\"form-floating\">
                        <input class=\"form-control\" type=\"password\" minlength=\"8\" name=\"inPass\" id=\"inPass\" value=\"\" placeholder=\" New Password\" required>
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
                    <input type=\"submit\" value=\"Save\" name=\"submit\" class=\"btn btn-green\">
                </div>
                </form>
            </div>
        </div>
    </div>
    
    <br>
    ";
}

function modal_delete_user(){
    echo "
    <button type=\"button\" class=\"btn btn-primary\" data-bs-toggle=\"modal\" data-bs-target=\"#delUserModal\">
        Delete Account
    </button>
    <div class=\"modal fade\" id=\"delUserModal\" tabindex=\"-1\" aria-labelledby=\"delUserModalLabel\" aria-hidden=\"true\">
        <div class=\"modal-dialog\">
            <div class=\"modal-content\">
                <div class=\"modal-header\">
                    <h1 class=\"modal-title fs-5\" id=\"delUserModalLabel\">Delete Account</h1>
                    <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\" aria-label=\"Close\"></button>
                </div>
                <form action=\"#\" method=\"post\" class=\"\">
                <div class=\"modal-body\">
                        Do you really want to delete this Account ?
                </div>
                <div class=\"modal-footer\">
                    <button type=\"button\" class=\"btn btn-secondary\" data-bs-dismiss=\"modal\">Close</button>
                    <input type=\"submit\" value=\"Confirm\" name=\"submit\" class=\"btn btn-green\">
                </div>
                </form>
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
        return newCode();
    }
}

//QR-Code generation

function showQR($code){
    echo "<div>
            <script src=\"https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js\"></script>
            <div id=\"qrcode\"></div>
            <script type=\"text/javascript\">
                new QRCode(document.getElementById(\"qrcode\"), \"$code\");
            </script>
            <p>$code</p>
        </div>";
}

?>