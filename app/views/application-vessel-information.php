<?php require APP_ROOT . 'views/include/header.php'; ?>

<body>
    <?php require APP_ROOT . 'views/components/userNavBar.php'; ?>
    <div class="container my-5 ">
        <?php require APP_ROOT . 'views/components/application-stage.php'; ?>
        <div class="container my-4">
            <div class="col-11" style="text-align: end">
                <form id="vesselimport" action="./?url=import-foreign-vessel-information" method="POST">
                    <div class="input-group my-3">
                    <input type="hidden" name="id" value="<?= $data['applicationId'] ?>">
                        <select class="form-select" name="foreign_vessel_id" aria-label="Foreign Vessel" required>
                            <option selected disabled>請選擇</option>
                            <?php foreach ($data['vessels'] as $vessel): ?>
                                <option value="<?= $vessel['id'] ?>" <?= $data['vessel']['foreign_vessel_id'] ?? 'null' == $vessel['id'] ? 'selected' : '' ?>><?= $vessel['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit" form="vesselimport" class="btn btn-success ms-1">
                            <i class="bi bi-save"> </i>匯入船舶資料
                        </button>
                    </div>
                </form>
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