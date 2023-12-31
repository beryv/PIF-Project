$(document).ready(function(){
    $("#centerSearchResult").load("./backend/center_search.backend.php");
    $("#centerSearch").on("keyup", function(){
        var center = document.getElementById("centerSearch").value;
        $("#centerSearchResult").load("./backend/center_search.backend.php", "search="+center);
    });
    $(document).on("click", "#centerSearchResult a", function(e){
        e.preventDefault();
        var centercode = $(this).attr("value");
        $("#favcenterAlert").load("./backend/profile_favcenter.backend.php", "centercode="+centercode);
    });
    $(document).on("click", "#favCenterReset", function(){
        var centercode = null;
        $("#favcenterAlert").load("./backend/profile_favcenter.backend.php", "centercode="+centercode);
    });
});