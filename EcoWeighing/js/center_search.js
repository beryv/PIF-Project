$(document).ready(function(){
    $("#centerSearchResult").load("./backend/center_search.backend.php");
    $("#centerSearch").on("keyup", function(){
        var center = document.getElementById("centerSearch").value;
        $("#centerSearchResult").load("./backend/center_search.backend.php", "search="+center);
    });
});