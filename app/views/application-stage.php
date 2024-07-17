<?php require APP_ROOT . 'views/include/header.php'; ?>
<style>
    .btn-container {
        display: flex;
        justify-content: space-around;
        margin-top: 50px;
    }

    .btn-large {
        padding: 20px 40px;
        font-size: 24px;
    }
</style>

<body>
<?php require APP_ROOT . 'views/components/userNavBar.php'; ?>
<div class="container my-5">
    <div class="row">
        <div class="col-md-12">
            <div class="btn-container">
                <?php if ($data[1] == false): ?>
                    <a href="./?url=page/create-application" class="btn btn-primary btn-lg btn-large" role="button">風場基本資料</a>
                <?php else : ?>
                    <a href="./?url=page/create-application" class="btn btn-secondary btn-lg btn-large" role="button">風場基本資料</a>
                <?php endif; ?>
                <?php if ($data[2] == false): ?>
                    <a href="./?url=page/application-requirement-spec&id=<?= $data['vessel_category_id'] ?>" class="btn btn-secondary btn-lg btn-large" role="button">需求規格</a>
                <?php else: ?>
                    <a href="./?url=page/application-requirement-spec&id=<?= $data['vessel_category_id'] ?>" class="btn btn-secondary btn-lg btn-large" role="button">需求規格</a>
                <?php endif; ?>
                <?php if ($data[3] == false): ?>
                    <a href="./?url=page/application-vessel" class="btn btn-secondary btn-lg btn-large" role="button">國外船舶選擇</a>
                <?php else: ?>
                    <a href="./?url=page/application-vessel" class="btn btn-secondary btn-lg btn-large" role="button">國外船舶選擇</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<script src="./js/datepicker.js"></script>
<?php require APP_ROOT . 'views/include/footer.php'; ?>
</body>