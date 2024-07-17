
<?php require APP_ROOT . '/views/include/header.php'; ?>
<body>
<?php require APP_ROOT . '/views/components/userNavBar.php'; ?>
<div class="container my-4">
    <div class="col-11" style="text-align: end">
        <button type="submit" form="vesselForm" class="btn btn-warning ms-1">
            <i class="bi bi-pencil-square"> </i>確定更新
        </button>
    </div>
    <form id="vesselForm" action="./?url=domesticShip/update-domestic-ship" method="POST">
        <?php require APP_ROOT ."views/components/update-domestic-ship.php";?>
    </form>
</div>
</body>
