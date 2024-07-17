<?php

$btnGroupContent = "";
require APP_ROOT . 'views/components/application-status-buttons.php';

$tbodyContent = "";
foreach ($data['applications'] as $index => $value) {
  $index += 1;
      $tbodyContent.= <<<HTML
          <tr>
              <td>{$index}</td>
              <td>{$value['applicant']}</td>
              <td>{$value['wind_farm']}</td>
              <td>{$value['vessel']}</td>
      HTML;
  if ($data['status'] == '審查會議') {
      $tbodyContent.= <<<HTML
          <td>{$value['official_document_number']}</td>
      HTML;
  } else if ($data['status'] == '通過') {
      $tbodyContent.= <<<HTML
          <td>{$value['approved_sailing_date']} 至 {$value['approved_return_date']}</td>
      HTML;
  }
  $tbodyContent.= <<<HTML
      <td>{$data['status']}</td>
      <td>
         <a href="./?url=page/applications/application&id={$value['id']}" role="button" class="btn btn-sm btn-success">
          查看詳細資訊 <i class="bi bi-folder-fill"></i>
        </a>
      </td>
  </tr>
HTML;


}
?>
<?php require APP_ROOT . 'views/include/header.php';?>
<body>
<?php require APP_ROOT . 'views/components/userNavBar.php';?>
<div class="container my-5">
    <div class="row">
        <div class="col-sm-12 mb-3 mb-sm-4">
            <div class="card">
                <div class="card-body">
                    <div class="row my-3">
                        <div class="col-6">
                            <h3 class="card-title">申請案管理</h3>
                        </div>
                        <div class="col-6" style="text-align: end">
                            <div class="btn-group">
                                <?= $btnGroupContent ?>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered mt-3">
                        <thead>
                        <tr>
                            <th class="table-primary" scope="col">#</th>
                            <th class="table-primary" scope="col">申請公司</th>
                            <th class="table-primary" scope="col">風場</th>
                            <th class="table-primary" scope="col">船名</th>
                            <th class="table-primary" scope="col" style="display: <?= $data['status'] == '審查會議' ? 'blocked': 'none'?>">函號</th>
                            <th class="table-primary" scope="col" style="display: <?= $data['status'] == '通過' ? 'blocked': 'none'?>">核准船期</th>
                            <th class="table-primary" scope="col">狀態</th>
                            <th class="table-primary" scope="col">操作</th>
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
</div>
</body>
