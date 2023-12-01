<div class="header">
    <a href="index.php?page=center" class="headerLogo">ECOWEIGHING</a>
    <div class="navbtn">
        <?php if(!isset($_SESSION["ConState"]) || $_SESSION["ConState"]!=true){ ?>
        <a href="index.php?page=aboutus" class="btn customBtn btn-green">ABOUT US</a>
        <a href="index.php?page=login" class="btn customBtn btn-green">LOGIN</a>
        <?php } else{ ?>
        <a href="index.php?page=profile&user=<?php echo $_SESSION["username"]?>" class="btn customBtn btn-green"><i class="bi bi-person-fill"></i></a>
        <a href="index.php?page=logout" class="btn customBtn btn-green" style="background-color:red; border-color:red;"><i class="bi bi-box-arrow-right"></i></a>
        <?php } ?>
    </div>
</div>