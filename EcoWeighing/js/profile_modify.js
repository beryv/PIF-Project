function save_modification(){
    $("form").submit(function(e){
        e.preventDefault();
    });

    if($("#inUser").val() == '' || $("#inUser").val().length > 100){
        $("#inUser").focus();
        return;
    }
    if($("#email").val() == '' || $("#email").val().length > 100){
        $("#email").focus();
        return;
    }
    if($("#fname").val() == '' || $("#fname").val().length > 100){
        $("#fname").focus();
        return;
    }
    if($("#lname").val() == '' || $("#lname").val().length > 100){
        $("#lname").focus();
        return;
    }

    var username = document.getElementById("inUser").value;
    var email = document.getElementById("email").value;
    var fname = document.getElementById("fname").value;
    var lname = document.getElementById("lname").value;

    $("#modifyAlert").load("./backend/profile_modify.backend.php", "username="+username+"&email="+email+"&fname="+fname+"&lname="+lname);
}