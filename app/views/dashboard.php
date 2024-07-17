<?php require APP_ROOT . 'views/include/header.php'; ?>
<body>
<?php require APP_ROOT . 'views/components/userNavBar.php'; ?>
<div class="container my-5">
  <div class="row mt-2">
    <div class="col-sm-6 mb-sm-3">
      <div class="card" style="background-color: #353A4A">
        <a href="./?url=page/ship-database-dashboard">
          <img class="card-img-top" src="./img/ship-database-dashboard2.png" alt="ship-database-dashboard">
        </a>
      </div>
    </div>
    <div class="col-sm-6 mb-3 mb-sm-4" style="display: <?= $_SESSION['identity'] == 'domestic_maritime_association' ? 'none' : 'block'?>">
      <div class="card" style="background-color: #353A4A">
        <a href="./?url=page/ship-application-dashboard">
          <img class="card-img-top" src="./img/ship-application-dashboard2.png" alt="ship-database-dashboard">
        </a>
      </div>
    </div>
  </div>
</div>
<?php require APP_ROOT . 'views/include/footer.php'; ?>
</body>