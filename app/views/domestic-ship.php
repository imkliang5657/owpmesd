<?php
$vesselsByCategory = '';
foreach ($data as $category => $vessels) {
    $head = <<<HTML
    <tr>
        <td class="col-2">
          <a class="btn btn-outline-dark" style="text-decoration:none" href="./?url=domesticShip/domestic-category-shipment&category_name=$category">$category</a>
          </td>
        <td>
    HTML;
    $body = '';
    foreach ($vessels as $vessel) {
        $id = $vessel['id'];
        $name = $vessel['name'];
        if($vessel['operation'] == 'add'){
          $body.= <<<HTML
            <a class="btn btn-success m-1" href="./?url=domesticShip/domestic-ship-information&ship_id=$id" role="button">$name</a>
          HTML;
        }
        else if($vessel['operation'] == 'modify'){
          $body.= <<<HTML
            <a class="btn btn-warning m-1" href="./?url=domesticShip/domestic-ship-information&ship_id=$id" role="button">$name</a>
          HTML;
        }
        else{
          $body.= <<<HTML
            <a class="btn btn-secondary m-1" href="./?url=domesticShip/domestic-ship-information&ship_id=$id" role="button">$name</a>
          HTML;
        }
    }
    $tail = <<<HTML
        </td>
    </tr>
    HTML;
    
    $vesselsByCategory .= $head . $body . $tail;
}
//處理新增成功或失敗的訊息
$displayMessage = "";
if(isset($_GET['error'])){
  switch($_GET['error']){
    case "creat":
      $message = "資料新增失敗：提交的船舶資料和其他船舶名字、MMSI、IMO可能重覆";
      $style = "danger";
      break;
    case "update":
      $message = "資料更新失敗：提更改後的船舶資料與其他船舶名字、MMSI、IMO可能重複";
      $style = "danger";
      break;
    case "upload":
      $message = "檔案上傳失敗：上傳檔案太大 或是 檔案型態不正確";
      $style = "danger";
      break;
    case "shipment":
      $message = "船期更新失敗：可能是船期撞期 或是 提交的日期不合邏輯";
      $style = "danger";
      break;
    case "success":
      $message = "資料匯入、更新成功";
      $style = "success";
      break;
  }
  $displayMessage = <<<HTML
        <div class="my-4">
          <div class="alert alert-$style" role="alert">$message</div>
        </div>
  HTML;
}
?>
<?php require APP_ROOT . 'views/include/header.php';?>
<body>
  <?php require APP_ROOT . 'views/components/userNavBar.php';?>
  <div class="container my-5">
    <div class="row">
      <div class="col-sm-12 mb-3 mb-sm-4">
        <div class="card p-2">
          <div class="card-body">
          <?=$displayMessage?>
            <div class="row">
              <div class="col-5">
                <h4 class="card-title mb-3">國內船舶資訊</h4>
              </div>
              <div class="col-7" style="text-align: end; display: <?= $_SESSION['identity'] == 'wind_farm_develover' ? 'none' : 'block' ?>">
                <a class="btn btn-success ms-1" href="./?url=domesticShip/create-domestic-ship" role="button">
                  <i class="bi bi-save"></i> 新增
                </a>
              </div>
            </div>
            <div style="text-align: end">
              <button type="button" class="btn btn-secondary"></button> 船舶資料未更動
              <button type="button" class="btn btn-success"></button> 新增船舶資料(兩周內)
              <button type="button" class="btn btn-warning"></button> 修改船舶資料(兩周內)
            </div>
            <table class="table table-bordered mt-3">
              <thead>
              <tr>
                <th class="table-primary">船種</th>
                <th class="table-primary">船名</th>
              </tr>
              </thead>
              <tbody class="table-group-divider">
                <?php echo $vesselsByCategory;?> 
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>