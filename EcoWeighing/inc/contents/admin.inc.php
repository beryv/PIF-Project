<?php
//if user not logged send to login
if(!isset($_SESSION["ConState"]) || $_SESSION["ConState"]!=true){
    echo "<script>window.location.href = 'index.php?page=login'</script>";
    die();
}
//if user not admin send to 401-Unauthorized
if(!isset($_SESSION["type"]) || $_SESSION["type"] != "adm"){
    echo "<script>window.location.href = 'index.php?page=401'</script>";
    die();
}

echo '<h1 class="text-center mt-5">Admin Panel</h1>';
echo '
<br>
<br>
<div class="admin-cards row  g-4">
  <div class="col">
    <div class="card h-100">
      <i class="bi bi-people"></i>
      <div class="card-body">
        <h5 class="card-title">Accounts</h5>
        <p class="card-text">Manage all Accounts</p>
        <a href="index.php?page=admin_users" class="stretched-link"></a>
      </div>
    </div>
  </div>
  <div class="col">
    <div class="card h-100">
      <i class="bi bi-cash-stack"></i>
      <div class="card-body">
        <h5 class="card-title">Bills</h5>
        <p class="card-text">Manage all Bills</p>
        <a href="#" class="stretched-link"></a>
      </div>
    </div>
  </div>
  <div class="col">
    <div class="card h-100">
      <i class="bi bi-list"></i>
      <div class="card-body">
        <h5 class="card-title">Measurments</h5>
        <p class="card-text">Manage all Measurments</p>
        <a href="#" class="stretched-link"></a>
      </div>
    </div>
  </div>
  <div class="col">
    <div class="card h-100">
      <i class="bi bi-buildings"></i>
      <div class="card-body">
        <h5 class="card-title">Centers</h5>
        <p class="card-text">Manage all Recycling Centers</p>
        <a href="#" class="stretched-link"></a>
      </div>
    </div>
  </div>
  <div class="col">
    <div class="card h-100">
      <i class="bi bi-pc"></i>
      <div class="card-body">
        <h5 class="card-title">Stations</h5>
        <p class="card-text">Manage all Measurments Stations</p>
        <a href="#" class="stretched-link"></a>
      </div>
    </div>
  </div>
  <div class="col">
    <div class="card h-100">
      <i class="bi bi-boxes"></i>
      <div class="card-body">
        <h5 class="card-title">Trash Types</h5>
        <p class="card-text">Manage all Trash Types</p>
        <a href="#" class="stretched-link"></a>
      </div>
    </div>
  </div>
</div>
';
?>