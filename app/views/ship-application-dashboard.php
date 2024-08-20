<?php require APP_ROOT . 'views/include/header.php'; ?>
<body>
<?php require APP_ROOT . 'views/components/userNavBar.php'; ?>
<div class="container my-5">
  <div class="row">
    <div class="col-sm-4 mb-3 mb-sm-4">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">新增申請案</h5>
          <p class="card-text text-secondary"></p>
          <a href="./?url=page/application-case" class="btn btn-sm btn-outline-success">點擊前往功能</a>
        </div>
      </div>
    </div>
    <div class="col-sm-4 mb-3 mb-sm-4">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">申請案追蹤</h5>
          <p class="card-text text-secondary"></p>
          <a href="./?url=page/application-manage" class="btn btn-sm btn-outline-success">點擊前往功能</a>
        </div>
      </div>
    </div>
    <div class="col-sm-4 mb-3 mb-sm-4" style="display: <?= $_SESSION['identity'] == 'wind_farm_develover' ? 'none' : 'block' ?>">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">申請案管理</h5>
          <p class="card-text text-secondary"></p>
          <a href="./?url=page/applications/manage" class="btn btn-sm btn-outline-success">點擊前往功能</a>
        </div>
      </div>
    </div>
  </div>
<?php require APP_ROOT . 'views/include/footer.php'; ?>
</body>