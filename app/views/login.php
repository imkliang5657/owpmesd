<?php
if ($data['error']) {
    $displayErrorMessage = <<<HTML
      <div class="m-3">
        <div class="alert alert-danger" role="alert">帳號或密碼輸入錯誤</div>
      </div>
    HTML;
} else {
    $displayErrorMessage = "";
}
?>

<?php require APP_ROOT . 'views/include/header.php'; ?>
<body>
<?php require APP_ROOT . 'views/components/publicNavBar.php'; ?>
<div class="container my-5">
  <div class="row mt-2">
    <div class="col-sm-5 mb-4 mb-sm-3">
      <div class="card">
        <div class="card-body">
          <form action="./?url=login" method="post">
            <h2 class="card-title text-center mb-4 mt-3">帳號登入</h2>
              <?= $displayErrorMessage ?>
            <div class="m-3">
              <hr class="border border-2">
            </div>
            <div class="m-3">
              <label for="inputAccount" class="form-label">帳號</label>
              <input name="account" type="text" required class="form-control" id="inputAccount"
                     placeholder="Account">
            </div>
            <div class="m-3">
              <label for="inputPassword" class="form-label">密碼</label>
              <input name="password" type="password" required class="form-control" id="inputPassword"
                     placeholder="Password">
            </div>
            <div class="m-3 mt-5">
              <div class="d-grid gap-2">
                <button type="submit" class="btn btn-success">登入</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?php require APP_ROOT . 'views/include/footer.php'; ?>
</body>