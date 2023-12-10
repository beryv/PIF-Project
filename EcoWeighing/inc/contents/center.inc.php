<?php
    //Check if user logged and has favourite center if not show random
    if(isset($_GET["center"]) && !empty($_GET["center"])){
        showCenter($_GET["center"]);
    }
    else if(isset($_SESSION["ConState"]) && $_SESSION["ConState"]==true && isset($_SESSION["favcenter"]) && $_SESSION["favcenter"] != null){
        showCenter($_SESSION["favcenter"]);
    }else{
        showCenter();
    }
?>