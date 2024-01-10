$(document).ready(function(){
    $(".login-form").submit(function(e){
        if($("#inUser").val() == ''){
            e.preventDefault();
            $("#inUser").focus();
            return;
        }
        if($("#inPass").val() == ''){
            e.preventDefault();
            $("#inPass").focus();
            return;
        }
    });
});