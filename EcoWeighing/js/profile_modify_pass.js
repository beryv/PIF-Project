function save_new_password(){
    $("form").submit(function(e){
        e.preventDefault();
    });

    if($("#inPassC").val() == '' || $("#inPassC").val().length < 8){
        $("#inPassC").focus();
        return;
    }
    if($("#inPass").val() == '' || $("#inPass").val().length < 8){
        $("#inPass").focus();
        return;
    }
    if($("#inPass2").val() == '' || $("#inPass2").val().length < 8){
        $("#inPass2").focus();
        return;
    }

    var curPass = document.getElementById("inPassC").value;
    var newPass = document.getElementById("inPass").value;
    var conPass = document.getElementById("inPass2").value;
    $("#passAlert").load("./backend/profile_modify_pass.backend.php", "curPass="+curPass+"&newPass="+newPass+"&conPass="+conPass);
}