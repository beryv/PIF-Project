function save_modification(){
    $("form").submit(function(e){
        e.preventDefault();
    });
    var username = document.getElementById("inUser").value;
    var email = document.getElementById("email").value;
    var fname = document.getElementById("fname").value;
    var lname = document.getElementById("lname").value;
    $("#modifyAlert").load("./backend/profile_modify.backend.php", "username="+username+"&email="+email+"&fname="+fname+"&lname="+lname);
}