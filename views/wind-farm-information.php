<?php require APP_ROOT . 'views/include/header.php'; ?>
<body>
<?php require APP_ROOT . 'views/components/userNavBar.php'; ?>
<div class="container my-5">
<div class="btn-group">
    <a href="./?url=page/wind-farm" class="btn  btn-warning">風場列表</a>
    <a href="./?url=page/wind-farm-new-form&id=<?= $data['id'] ?>" class="btn btn-primary" style="display: <?= $_SESSION['identity'] == 'domestic_maritime_association' ? 'none' : 'block'; ?>">前往新增</a>
</div>
    <p class="fs-2"><?= $data['windFarm']['name'] ?></p>
    <p class="card-text"><?= $data['windFarm']['introduction'] ?></p>
    <div class="row min-vh-100 mt-2" id="form-container">
        
        <?php foreach ($data['windFarmInformation'] as $info): ?>
            <?php $id = $info['id']; ?>
            <?php require APP_ROOT . 'views/components/wind-farm-new-form.php'; ?>
        <?php endforeach; ?>
    </div>
</div>
<script src="./js/datepicker.js"></script>
<?php require APP_ROOT . 'views/include/footer.php'; ?>
</body>