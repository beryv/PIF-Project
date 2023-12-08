function delete_accoutn(){
    $("form").submit(function(e){
        e.preventDefault();
    });
    $("#deleteAlert").load("./backend/profile_delete.backend.php");
}