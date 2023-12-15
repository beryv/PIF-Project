<div class="header">
    <a href="index.php?page=center" class="headerLogo">ECOWEIGHING</a>
    <div class="navbtn">
        <?php if(!isset($_SESSION["ConState"]) || $_SESSION["ConState"]!=true){ ?>
        <a href="index.php?page=aboutus" class="btn customBtn btn-green">ABOUT US</a>
        <a href="index.php?page=login" class="btn customBtn btn-green">LOGIN</a>
        <?php } else{ ?>
        <div class="dropdown">
            <button class="btn customBtn btn-green dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                <?php echo substr($_SESSION["username"], 0, 10)?> <i class="bi bi-person-fill"></i>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                <li><a class="dropdown-item" href="index.php?page=profile&user=<?php echo $_SESSION["username"]?>">Profile</a></li>
                <li><a class="dropdown-item" href="index.php?page=myhistory">My History</a></li>
                <li><a class="dropdown-item" href="#">(Admin Panel)</a></li>
                <li><a class="dropdown-item text-danger" href="index.php?page=logout">Logout <i class="bi bi-box-arrow-right"></i></a></li>
            </ul>
        </div>
        <?php } ?>
    </div>
</div>