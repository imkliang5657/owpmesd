<?php require APP_ROOT . 'views/include/header.php'; ?>
<body>
<?php require APP_ROOT . 'views/components/userNavBar.php'; ?>
<div class="container my-5">
    <?php require APP_ROOT . 'views/components/application-stage.php'; ?>
    <div class="row mt-2">
        <div class="col-sm-5 mb-4 mb-sm-4">
            <div class="card p-2">
                <form method="post" action="./?url=upsert-application-case" id="form">
                    <input type="hidden" name="application_id" value="<?= $data['applicationId'] ?>">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5">
                                <h4 class="card-title mb-3">基本資料</h4>
                            </div>
                        </div>
                        <div class="input-group my-3">
                            <span class="input-group-text">風場</span>
                            <select class="form-select" name="wind_farm_id" aria-label="wind_farm_id" required>
                                <option selected disabled></option>
                                <?php foreach ($data['windFarms'] as $windFarm): ?>
                                    <option value="<?= $windFarm['id'] ?>" <?= ($data['applicationInformation']['wind_farm_id'] ?? null) == $windFarm['id'] ? 'selected' : '' ?>><?= $windFarm['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">工作項目</span>
                            <input type="text" class="form-control" name="work_item" value="<?= $data['applicationInformation']['work_item'] ?? null ?>">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">船種</span>
                            <select class="form-select" name="vessel_category_id" aria-label="vessel_category_id" required>
                                <option selected disabled></option>
                                <?php foreach ($data['vesselCategories'] as $category): ?>
                                    <option value="<?= $category['id'] ?>" <?= ($data['applicationInformation']['vessel_category_id'] ?? null) == $category['id'] ? 'selected' : '' ?>><?= $category['vessel_category_name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">使用船期</span>
                            <input type="text" id="required_sailing_date" class="form-control datepicker" name="required_sailing_date" value="<?= $data['applicationInformation']['required_sailing_date'] ?? null ?>">
                            <span class="input-group-text">至</span>
                            <input type="text" id="required_return_date" class="form-control datepicker" name="required_return_date" value="<?= $data['applicationInformation']['required_return_date'] ?? null ?>">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">描述</span>
                            <textarea class="form-control" rows="10" aria-label="With textarea" name="description"><?= $data['applicationInformation']['description'] ?? null ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="bi bi-send"></i> 確認</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="./js/datepicker.js"></script>
<script>
    $(document).ready(function() {
        $('#form').submit(function(event) {
            const beginDate = new Date($('#required_sailing_date').val());
            const endDate = new Date($('#required_return_date').val());
            if (endDate < beginDate) {
                alert('使用船期之結束日期不得早於開始日期');
                event.preventDefault();
            }
        });
    });
</script>
<?php require APP_ROOT . 'views/include/footer.php'; ?>
</body>