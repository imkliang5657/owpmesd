<?php require APP_ROOT . 'views/include/header.php'; ?>
<body>
<?php require APP_ROOT . 'views/components/userNavBar.php'; ?>
<div class="container m-5 ">
  <div class="card-head">
    <div class="row">
      <div class="col-3">
        <h4 class="card-title mb-3">
          需求規格
        </h4>
      </div>
    </div>
  </div>
  <div class="card-body">
    <form method="post" action="./?url=create-requirement">
      <input type="hidden" name="application_id" value="<?= $data['application_id'] ?>">
        <?php foreach ($data['columns'] as $index => $column): ?>
          <div class="input-group my-3">
            <span class="input-group-text" style="width: 15%;"><?= $column ?></span>
            <span class="input-group-text">為</span>
            <input type="text" class="form-control" name="specification_<?= $index + 1 ?>" placeholder="">
          </div>
        <?php endforeach; ?>
      <button type="submit" class="btn btn-success ms-1"><i class="bi bi-cursor-fill"></i> 提交</button>
    </form>
  </div>
</div>
<script src="./js/datepicker.js"></script>
<?php require APP_ROOT . 'views/include/footer.php'; ?>
</body>