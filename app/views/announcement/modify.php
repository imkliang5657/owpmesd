<?php
$fileLinks = "";
if(!empty($data['files'])) {
    foreach ($data['files'] as $file)
        $fileLinks .= <<<HTML
      <a href="./file/{$file['name']}" download="./file/{$file['name']}" class="btn btn-sm btn-outline-secondary" tabindex="-1" role="button">
        <i class="bi bi-file-earmark-text-fill"></i> {$file['name']}
      </a>
    HTML;
}

if ($data['success']) {
    $displayMessage = <<<HTML
      <div class="alert alert-success">修改成功 !</div>
    HTML;
} else {
    $displayMessage = "";
}
?>


<?php require APP_ROOT . 'views/include/header.php';?>
<body>
<?php require APP_ROOT . 'views/components/userNavBar.php';?>
<div class="container my-5">
    <div class="row mt-2">
        <div class="col-sm-12">
            <div class="card">
                <form action=".?url=update/announcements/announcement&id=<?= $data['announcement']['id']?>" method="post">
                <div class="card-header">
                    <div class="row">
                        <div class="col-9 py-1 px-4">
                            <h5 class="my-2"><i class="bi bi-info-circle-fill"></i> <?= $data['announcement']['title'] ?></h5>
                        </div>
                        <div class="col-3 py-1 px-4" style="text-align: end">
                            <button class="btn btn-success" type="submit">
                                <i class="bi bi-floppy2-fill"></i> 儲存</button>
                        </div>
                    </div>
                </div>
                <div class="card-body p-5">
                    <?= $displayMessage ?>
                    <div class="mb-4">
                        <label for="exampleFormControlInput1" class="form-label">公告標題</label>
                        <input name="title" type="text" value="<?= $data['announcement']['title']?>" class="form-control" id="exampleFormControlInput1" placeholder="請輸入標題">
                    </div>
                    <div class="mb-4">
                        <label for="exampleFormControlInput1" class="form-label">發布組織</label>
                        <input name="organization" type="text" value="<?= $data['announcement']['organization']?>" class="form-control" id="exampleFormControlInput1" placeholder="請輸入組織名稱">
                    </div>
                    <div class="mb-4">
                        <label for="exampleFormControlTextarea1" class="form-label">公告內容</label>
                        <textarea name="content" class="form-control" id="exampleFormControlTextarea1" rows="3"
                                  placeholder="請輸入您想要公告的內容(如果是外部連結的話請填上連結網址)"><?= $data['announcement']['content']?>
                        </textarea>
                    </div>
                    <label for="exampleFormControlInput1" class="form-label">內容是否為外部連結？</label>
                    <div class="mb-4">
                        <div class="form-check form-check-inline">
                            <input name="is_link" class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="1" <?= $data['announcement']['is_link'] ? "checked" : ""?>>
                            <label class="form-check-label" for="inlineRadio1">是</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input name="is_link" class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="0" <?= $data['announcement']['is_link'] ? "" : "checked"?>>
                            <label class="form-check-label" for="inlineRadio2">否</label>
                        </div>
                    </div>
                </div>
                <div class="card-footer mt-2">
                    由<?= $data['announcement']['organization']?> 於 <?= $data['announcement']['updated_at']?> 發布
                </div>
                </form>
            </div>
        </div>
    </div>
    <script src="./js/datepicker.js"></script>
</body>
