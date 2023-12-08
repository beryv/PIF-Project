<?php
    //Check if user logged and has favourite center if not show random
    if(isset($_SESSION["ConState"]) && $_SESSION["ConState"]==true && isset($_SESSION["favcenter"]) && $_SESSION["favcenter"] != null){
        $row = getCenter($_SESSION["favcenter"]);
        echo "<p>Center code: ".$row["CENTERCODE"]."</p>";
        echo "<p>Adress: ".$row["ADRESS"]."</p>";
        echo "<p>Postcode: ".$row["POSTCODE"]."</p>";
        echo "<p>City: ".$row["CITY"]."</p>";
        getSchedules($_SESSION["favcenter"]);
    }else{
        $row = getCenter();
        echo "<p>Center code: ".$row["CENTERCODE"]."</p>";
        echo "<p>Adress: ".$row["ADRESS"]."</p>";
        echo "<p>Postcode: ".$row["POSTCODE"]."</p>";
        echo "<p>City: ".$row["CITY"]."</p>";
        getSchedules($row["CENTERCODE"]);
    }
?>