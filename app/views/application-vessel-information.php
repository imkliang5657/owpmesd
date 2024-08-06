<?php require APP_ROOT . 'views/include/header.php'; ?>
<body>
    <?php require APP_ROOT . 'views/components/userNavBar.php'; ?>
    <div class="container my-5 ">
        <?php require APP_ROOT . 'views/components/application-stage.php'; ?>
        <div class="container my-4">
            <div class="col-11" style="text-align: end">
                <button type="submit" form="vesselForm" class="btn btn-success ms-1">
                    <i class="bi bi-save"> </i>確定新增
                </button>
            </div>
            <form id="vesselForm" action="./?url=upsert-application-foreign-vessel-information" method="POST">
                <?php
                if (!isset($data['vessel_detail_id'])) {
                    require APP_ROOT . "views/components/application-ship-information.php";
                } else {
                    require APP_ROOT . "views/components/create-detail-information.php";
                }
                ?>
            </form>
        </div>
</body>