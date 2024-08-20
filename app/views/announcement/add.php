<?php

?>

<?php require APP_ROOT . 'views/include/header.php';?>
<body>
<?php require APP_ROOT . 'views/components/userNavBar.php';?>
<div class="container my-5">
    <div class="row mt-2">
        <div class="col-sm-12">
            <div class="card">
                <form action=".?url=create/announcements/announcement" method="post">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-9 py-1 px-4">
                              <h4 class="my-2">新增公告</h4>
                            </div>
                            <div class="col-3 py-1 px-4" style="text-align: end">
                                <button class="btn btn-success" type="submit">
                                    <i class="bi bi-floppy2-fill"></i> 送出</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-5">
                        <div class="mb-4">
                            <label for="exampleFormControlInput1" class="form-label">公告標題</label>
                            <input name="title" type="text" class="form-control" id="exampleFormControlInput1" placeholder="請輸入標題">
                        </div>
                        <div class="mb-4">
                            <label for="exampleFormControlInput1" class="form-label">發布組織</label>
                            <input name="organization" type="text" class="form-control" id="exampleFormControlInput1" placeholder="請輸入組織名稱">
                        </div>
                        <div class="mb-4">
                            <label for="exampleFormControlTextarea1" class="form-label">公告內容</label>
                            <textarea name="content" class="form-control" id="exampleFormControlTextarea1" rows="3"
                                      placeholder="請輸入您想要公告的內容(如果是外部連結的話請填上連結網址)"></textarea>
                        </div>
                        <label for="exampleFormControlInput1" class="form-label">內容是否為外部連結？</label>
                        <div class="mb-4">
                            <div class="form-check form-check-inline">
                                <input name="is_link" class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="1">
                                <label class="form-check-label" for="inlineRadio1">是</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input name="is_link" class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="0">
                                <label class="form-check-label" for="inlineRadio2">否</label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="./js/datepicker.js"></script>
</body>
