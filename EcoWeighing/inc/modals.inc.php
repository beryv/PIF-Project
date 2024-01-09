<?php
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
                            <b>Do you really want to delete this Account ?</b>
                            <br>
                            <small>(All asociated data will be deleted)</small>
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
                        In case the QR dosen't show up do following:
                        <h4 class=\"mt-3\">Step 1</h4>
                        Copy the code showed on your Profile.
                        <h4 class=\"mt-3\">Step 2</h4>
                        Go on a QR-code Generator website.<br>
                        Like this one: <a href=\"https://qr.io/?gad_source=1&gclid=EAIaIQobChMIjd2NkIGAgwMVDJSDBx3XGgOhEAAYAyAAEgJS7vD_BwE\">Click</a>
                        <h4 class=\"mt-3\">Step 3</h4>
                        Generate your QR-Code using your code.
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

?>