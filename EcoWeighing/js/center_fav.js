$(document).ready(function(){
    $("#UnFavCenter").on("click", function(){
        var centercode = null;
        $("body").load("./backend/profile_favcenter.backend.php", "centercode="+centercode+"&fromCenter=true");
    });
    $("#FavCenter").on("click", function(){
        var centercode = $(this).val();
        $("body").load("./backend/profile_favcenter.backend.php", "centercode="+centercode+"&fromCenter=true");
    });
});