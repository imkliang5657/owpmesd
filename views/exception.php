<?php require APP_ROOT . 'views/include/header.php'; ?>
<?php require APP_ROOT . 'views/components/publicNavBar.php'; ?>
<body>
<div class="container my-5">
  <div class="row mt-2">
    <div class="col-sm-12">
      <p class="display-4"><i class="bi bi-bug-fill"></i> <?= $data['status'] ?></p>
      <h5><?= $data['message'] ?></h5>
    </div>
  </div>
</div>
<?php require APP_ROOT . 'views/include/footer.php'; ?>
</body>