<?php require APP_ROOT . 'views/include/header.php'; ?>
<body>
<?php require APP_ROOT . 'views/components/userNavBar.php'; ?>
<div class="container my-5">
    <div class="card p-2">
        <div class="card-body">
            <div class="row">
                <div class="col-5">
                    <h4 class="card-title mb-3">船舶資料</h4>
                </div>
                <div class="col-7" style="text-align: end">
                    <button type="button" class="btn btn-secondary ms-1">
                        <i class="bi bi-save"></i> 匯入規格書
                    </button>
                    <button type="button" class="btn btn-secondary ms-1">
                        <i class="bi bi-save"></i> 匯入船級證書
                    </button>
                </div>
            </div>
            <div class="input-group my-3">
                <span class="input-group-text" id="basic-addon1">船名</span>
                <input type="text" class="form-control" value="">
            </div>

            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">IMO</span>
                <input type="text" class="form-control" value="">
            </div>
            <div class="input-group my-3">
                <span class="input-group-text">規格一</span>
                <input type="text" class="form-control" value="">
                <span class="input-group-text">為</span>
                <input type="text" class="form-control" placeholder="">
                <input type="text" class="form-control" placeholder="">
            </div>
            <div class="input-group my-3">
                <span class="input-group-text">規格二</span>
                <input type="text" class="form-control" value="">
                <span class="input-group-text">為</span>
                <input type="text" class="form-control" placeholder="">
                <input type="text" class="form-control" placeholder="">
            </div>
            <div class="input-group my-3">
                <span class="input-group-text">規格三</span>
                <input type="text" class="form-control" value="">
                <span class="input-group-text">為</span>
                <input type="text" class="form-control" placeholder="">
                <input type="text" class="form-control" placeholder="">
            </div>
            <div class="input-group my-3">
                <span class="input-group-text">規格四</span>
                <input type="text" class="form-control" value="">
                <span class="input-group-text">為</span>
                <input type="text" class="form-control" placeholder="">
                <input type="text" class="form-control" placeholder="">
            </div>
            <div class="input-group my-3">
                <span class="input-group-text">規格五</span>
                <input type="text" class="form-control" value="">
                <span class="input-group-text">為</span>
                <input type="text" class="form-control" placeholder="">
                <input type="text" class="form-control" placeholder="">
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-floppy"></i> 送出</button>
        </div>
    </div>
</div>


<script src="./js/datepicker.js"></script>
<?php require APP_ROOT . 'views/include/footer.php'; ?>
</body>