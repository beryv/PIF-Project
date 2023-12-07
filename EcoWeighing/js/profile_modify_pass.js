function save_new_password(){
    $("form").submit(function(e){
        e.preventDefault();
    });
    var curPass = document.getElementById("inPassC").value;
    var newPass = document.getElementById("inPass").value;
    var conPass = document.getElementById("inPass2").value;
    $("#passAlert").load("./backend/profile_modify_pass.backend.php", "curPass="+curPass+"&newPass="+newPass+"&conPass="+conPass);
}