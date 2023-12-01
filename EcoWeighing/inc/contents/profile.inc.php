<?php
//if user not logged send to center
if(!isset($_SESSION["ConState"]) || $_SESSION["ConState"]!=true){
    echo "<script>window.location.href = 'index.php?page=center'</script>";
}
?>
<h1>Profile</h1>