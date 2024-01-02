<?php
//Formulars

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
        <div class=\"form-check form-check-inline checkbox-lg\">
            <input class=\"form-check-input\" type=\"checkbox\" name=\"remember\" id=\"remember\">
            <label class=\"form-check-label\" for=\"remember\">Remember me ?</label>
        </div>
        <br>
        <br>
        <a href=\"index.php?page=newuser\" class=\"btn customBtn btn-secondary\">New User</a>
        <input type=\"submit\" value=\"Sign in\" name=\"submit\" class=\"btn customBtn btn-green\">
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
?>