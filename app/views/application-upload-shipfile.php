<?php require APP_ROOT . 'views/include/header.php'; ?>

<body>
<?php require APP_ROOT . 'views/components/userNavBar.php'; ?>
<div class="container my-5 ">
    <?php require APP_ROOT . 'views/components/application-stage.php'; ?>
    <div class="card p-2">
        <div class="card-body"></div>
<div class="container">
        <h1 class="mb-4">上傳檔案</h1>

        <form id="form" action="?url=upsert-application-upload-shipfile&id=<?= $data['applicationId'] ?>" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="certificate_of_classification" class="form-label">船級證書</label>
                <input class="form-control" type="file" id="certificate_of_classification" name="certificate_of_classification" value="" required>
                <?=$data['file'][0]['name']?>
            </div>
            <div class="mb-3">
                <label for="specification" class="form-label">船舶規格書</label>
                <input class="form-control" type="file" id="specification" name="specification"  value="" required>
                <?=$data['file'][1]['name']?>
            </div>
            <div class="mb-3">
                <label for="reference" class="form-label">其他資料</label>
                <input class="form-control" type="file" id="reference" name="reference"  value="" >
                <?=$data['file'][2]['type']=='reference' ? $data['file'][2]['name']: null?>
            </div>

            <button type="submit" class="btn btn-primary">上傳</button>
        </form>
    </div>
</div>
<?php require APP_ROOT . 'views/include/footer.php'; ?>
</body>