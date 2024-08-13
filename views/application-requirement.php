<?php require APP_ROOT . 'views/include/header.php'; ?>
<body>
<?php require APP_ROOT . 'views/components/userNavBar.php'; ?>
<div class="container m-5">
    <?php require APP_ROOT . 'views/components/application-stage.php'; ?>
  <div class="card-head">
    <div class="row">
      <div class="col-3">
        <h4 class="card-title text-light mb-3">
          需求規格
        </h4>
      </div>
    </div>
  </div>
  <div class="card-body">
    <form method="post" action="./?url=upsert-requirement">
      <input type="hidden" name="application_id" value="<?= $data['applicationId'] ?>">
      <input type="hidden" name="id" value="<?= $data['vesselDetail']['id'] ?>">
        <?php foreach ($data['columns'] as $index => $column): ?>
          <div class="input-group my-3">
            <span class="input-group-text" style="width: 15%;"><?= $column ?></span>
            <span class="input-group-text">為</span>
            <input type="text" class="form-control" name="specification_<?= $index + 1 ?>" value="<?= $data['vesselDetail']['specification_' . $index + 1] ?? null ?>">
          </div>
        <?php endforeach; ?>
      <button type="submit" class="btn btn-primary ms-1"><i class="bi bi-send"></i> 確認</button>
    </form>
  </div>
</div>
<?php require APP_ROOT . 'views/include/footer.php'; ?>
</body>