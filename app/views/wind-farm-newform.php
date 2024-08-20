<?php require APP_ROOT . 'views/include/header.php'; ?>
<body>
<?php require APP_ROOT . 'views/components/userNavBar.php'; ?>
<div class="container my-5">
    <a href="./?url=page/wind-farm-information&id=<?=$data['id']?>" class="btn btn-primary">歷史紀錄</a>
    <p class="fs-2"><?= $data['windFarm']['name'] ?></p>
    <p class="card-text"><?=$data['windFarm']['introduction']?></p>
    <div class="row min-vh-100 mt-2" id="form-container">
        <?php require APP_ROOT . 'views/components/wind-farm-new-form.php'; ?>
    </div>
</div>
<script src="./js/datepicker.js"></script>
<?php require APP_ROOT . 'views/include/footer.php'; ?>
</body>