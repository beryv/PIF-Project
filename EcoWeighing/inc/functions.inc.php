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

?>