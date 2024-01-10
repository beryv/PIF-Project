$(document).ready(function(){
    $(".login-form").submit(function(e){
        if($("#inUser").val() == '' || $("#inUser").val().length > 100){
            e.preventDefault();
            $("#inUser").focus();
            return;
        }
        if($("#email").val() == '' || $("#email").val().length > 100){
            e.preventDefault();
            $("#email").focus();
            return;
        }
        if($("#fname").val() == '' || $("#fname").val().length > 100){
            e.preventDefault();
            $("#fname").focus();
            return;
        }
        if($("#lname").val() == '' || $("#lname").val().length > 100){
            e.preventDefault();
            $("#lname").focus();
            return;
        }
        if($("#inPass").val() == '' || $("#inPass").val().length < 8){
            e.preventDefault();
            $("#inPass").focus();
            return;
        }
        if($("#inPass2").val() == '' || $("#inPass2").val().length < 8){
            e.preventDefault();
            $("#inPass2").focus();
            return;
        }
    });
});