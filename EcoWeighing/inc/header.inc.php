<div class="header">
    <a href="index.php?page=center" class="headerLogo">ECOWEIGHING</a>
    <div class="navbtn">
        <?php if(!isset($_SESSION["ConState"]) || $_SESSION["ConState"]!=true){ ?>
        <a href="index.php?page=aboutus" class="btn customBtn btn-green">About Us</a>
        &nbsp;
        <a href="index.php?page=login" class="btn customBtn btn-green">Login <i class="bi bi-box-arrow-in-right"></i></a>
        <?php } else{ ?>
        <div class="dropdown">
            <button class="btn customBtn btn-green dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-person-fill"></i> <?php echo substr($_SESSION["username"], 0, 10)?>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                <li><a class="dropdown-item" href="index.php?page=profile&user=<?php echo $_SESSION["username"]?>"><i class="bi bi-person-badge"></i> Profile</a></li>
                <li><a class="dropdown-item" href="index.php?page=myhistory"><i class="bi bi-list"></i> History</a></li>
                <?php if(isset($_SESSION["type"]) && $_SESSION["type"] == "adm"){echo "<li><a class=\"dropdown-item\" href=\"index.php?page=admin\"><i class=\"bi bi-tv\"></i> Admin</a></li>";} ?>
                <li><a class="dropdown-item text-danger" href="index.php?page=logout"><i class="bi bi-box-arrow-in-right"></i> Logout</a></li>
            </ul>
        </div>
        <?php } ?>
    </div>
</div>