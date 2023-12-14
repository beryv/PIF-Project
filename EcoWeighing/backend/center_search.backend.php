<?php
session_start();
include("../inc/db_params.inc.php");
include("../inc/functions.inc.php");

    
        $link = mysqli_connect(HOST,DB_USER,DB_PASSWORD,DATABASE) OR die();
        if(isset($_GET["search"])){
            $search = mysqli_real_escape_string($link,$_GET["search"]);
        }else{
                $search = null;
        }
        $query = strip_tags("SELECT * FROM TBLCENTERS
                                WHERE CENTERCODE LIKE '%$search%'
                                OR CITY LIKE '%$search%'");

        $result = mysqli_query($link,$query) OR die(mysqli_error($link));
        if(mysqli_num_rows($result) >= 1){
            while($row = mysqli_fetch_assoc($result)){
                echo "<a href=\"index.php?page=center&center=".$row["CENTERCODE"]."\" class=\"list-group-item list-group-item-action\" value=\"".$row["CENTERCODE"]."\" >".$row["CENTERCODE"]." - ".$row["CITY"]."</a>";
            }
        }else{
            echo "<a href=\"#\" class=\"list-group-item list-group-item-action\">No Centers Found</a>";
        }
        mysqli_close($link);
?>