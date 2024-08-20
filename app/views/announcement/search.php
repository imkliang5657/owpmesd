<?php
foreach ($data['organizations'] as $organization) {
    $options = '<option selected value="">全部</option>';
    $options .= <<< HTML
    <option value="{$organization['name']}">{$organization['name']}</option>
  HTML;
}

$indentity = $_SESSION['identity'] == 'admin' || $_SESSION['identity'] == 'ship_center' ? 'inline-block' : 'none';

$tbodyContent = "";
foreach ($data['announcements'] as $announcement) {
    $announcement['updated_at'] = date("Y-m-d",strtotime($announcement['updated_at']));
    if ($announcement['is_link']) {
        $tbodyContent .= <<< HTML
        <tr>
          <td>{$announcement['updated_at']}</td>
          <td>
            <a href="{$announcement['content']}" target="_blank" class="link-success link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">
              {$announcement['title']}
              <i class="bi bi-arrow-up-right-square"></i>
            </a>
          </td>
          <td>{$announcement['organization']}</td>
          <td style="display: {$indentity}">
            <a href=".?url=page/announcements/announcement/modify&id={$announcement['id']}" class="btn btn-warning btn-sm" tabindex="-1" role="button"><i class="bi bi-pencil-square"></i></a>
            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal{$announcement['id']}"><i class="bi bi-trash3-fill"></i></button>
          </td>
          <div class="modal fade" id="exampleModal{$announcement['id']}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="exampleModalLabel">確定刪除此公告嗎？</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <p>執行此動作後，將無法取消！</p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                  <a href=".?url=delete/announcements/announcement&id={$announcement['id']}" class="btn btn-danger" tabindex="-1" role="button">確定</a>
                </div>
              </div>
            </div>
          </div>
          </td>
        </tr>
      HTML;
    } else {
        $tbodyContent .= <<< HTML
        <tr>
          <td>{$announcement['updated_at']}</td>
          <td>
            <a href="./?url=page/announcements/announcement&id={$announcement['id']}" target="_blank" class="link-body-emphasis link-offset-2 link-underline-opacity-0 link-underline-opacity-100-hover">
              {$announcement['title']}
            </a>
          </td>
          <td>{$announcement['organization']}</td>
          <td style="display: {$indentity}">
            <a href=".?url=page/announcements/announcement/modify&id={$announcement['id']}" class="btn btn-warning btn-sm" tabindex="-1" role="button"><i class="bi bi-pencil-square"></i></a>
            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal{$announcement['id']}"><i class="bi bi-trash3-fill"></i></button>
          </td>
          <div class="modal fade" id="exampleModal{$announcement['id']}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="exampleModalLabel">確定刪除此公告嗎？</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <p>執行此動作後，將無法取消！</p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                  <a href=".?url=delete/announcements/announcement&id={$announcement['id']}" class="btn btn-danger" tabindex="-1" role="button">確定</a>
                </div>
              </div>
            </div>
          </div>
        </tr>
      HTML;
    }
}
?>
<?php require APP_ROOT . 'views/include/header.php';?>
<body>
<?php require APP_ROOT . 'views/components/userNavBar.php';?>
<div class="container my-5">
  <div class="row mt-2">
    <div class="col-sm-12 mb-4 mb-sm-4">
      <div class="card p-2">
        <div class="card-body">
          <form method="get">
            <input type="hidden" name="url" value="page/announcements">
            <div class="row">
              <div class="col-9">
                <h3 class="card-title">篩選查詢</h3>
              </div>
              <div class="col-3" style="text-align: end">
                <button class="btn btn-success" type="submit" id="button-addon2">
                  <i class="bi bi-search"></i> 查詢
                </button>
                <a href=".?url=page/announcements" class="btn btn-danger" tabindex="-1" role="button">重置條件</a>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-7">
                <div class="input-group my-3">
                  <span class="input-group-text" id="basic-addon1">關鍵字</span>
                  <input type="text" class="form-control" value="<?= $_GET['keyWord'] ?? NULL ?>" name="keyWord">
                </div>
              </div>
              <div class="col-sm-5">
                <div class="input-group my-3">
                  <span class="input-group-text" id="basic-addon1">發布單位</span>
                  <select class="form-select" aria-label="Default select example" name="organization_id">
                      <?= $options ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text" id="basic-addon1">發布年月日</span>
              <input type="text" class="form-control datepicker" name="startDate" value="<?= $_GET['startDate'] ?? NULL ?>">
              <span class="input-group-text" id="basic-addon1">至</span>
              <input type="text" class="form-control datepicker" name="endDate" value="<?= $_GET['endDate'] ?? NULL ?>">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-12 mb-3 mb-sm-4">
      <div class="card p-2">
        <div class="card-body">
          <div class="row">
            <div class="col-9">
              <h3 class="card-title mb-3">訊息公告
              <a href="./?url=page/announcements/announcement/add" class="btn btn-sm btn-primary mb-1 ms-1" tabindex="-1" role="button" style="display: <?= $_SESSION['identity'] == 'admin' || $_SESSION['identity'] == 'ship_center' ? 'inline-block' : 'none' ?>">新增</a></h3>
            </div>
            <div class="col-3" style="text-align: end">
              <div class="input-group">
                <span class="input-group-text" id="basic-addon1">每頁筆數</span>
                <select class="form-select" aria-label="Default select example">
                  <option selected>10</option>
                  <option value="1">25</option>
                  <option value="2">50</option>
                </select>
                <button class="btn btn-secondary" type="button" id="button-addon2">
                  <i class="bi bi-arrow-clockwise"></i>
                </button>
              </div>
            </div>
          </div>
          <table class="table table-bordered mt-3">
            <thead>
            <tr>
              <th class="table-primary" scope="col">發布日期</th>
              <th class="table-primary" scope="col">標題</th>
              <th class="table-primary" scope="col">組織</th>
              <th class="table-primary" scope="col" style="display: <?= $_SESSION['identity'] == 'admin' || $_SESSION['identity'] == 'ship_center' ? 'block' : 'none' ?>">操作</th>
            </tr>
            </thead>
            <tbody>
            <?= $tbodyContent ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <script src="./js/datepicker.js"></script>
</body>

