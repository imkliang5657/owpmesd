<?php require APP_ROOT . 'views/include/header.php'; ?>

<body>
<?php require APP_ROOT . 'views/components/userNavBar.php'; ?>
<div class="container my-5 ">
    <div class="card p-2">
        <div class="card-body">
            <div class="row">
                <div class="col-5">
                    <h4 class="card-title mb-3">國外船舶選擇</h4>
                </div>
            </div>
            <form method="post" action="./?url=create-application-vessel">
                <input type="hidden" name="application_id" value="<?= $data['application_id'] ?>">
                <div class="input-group my-3">
                    <select class="form-select" name="foreign_vessel_id" aria-label="Foreign Vessel" required>
                        <option selected disabled>請選擇</option>
                        <?php foreach ($data['vessels'] as $vessel): ?>
                            <option value="<?= $vessel['id'] ?>"><?= $vessel['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" class="btn btn-success ms-1"><i class="bi bi-cursor-fill"></i> 提交</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="./js/datepicker.js"></script>
<?php require APP_ROOT . 'views/include/footer.php'; ?>
</body>