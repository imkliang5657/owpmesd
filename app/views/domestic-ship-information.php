<?php
//顯示承諾船期
$promiseShipment = "";
foreach ($data as $key => $value) {
    if (is_array($value)) {
        if (isset($value['promise_sailing_date']) && isset($value['promise_return_date'])) {
            $sailing_date = $value['promise_sailing_date'];
            $return_date = $value['promise_return_date'];
            $promiseShipment .= <<<HTML
                $sailing_date ~ $return_date<br>
            HTML;
        }
    }
}
if (empty($promiseShipment)) {
    $promiseShipment = "尚未有船期";
}
if((isset($_GET['addPromiseShipment'])) && $_GET['addPromiseShipment'] == 1){ 
$vesselId = $data['id'];
$fillPromiseShipment = <<<HTML
<div class="container mt-1">
    <div class="row">
      <div class="col-12">
        <form id="shipmentForm" action="./?url=domesticShip/add-promise-shipment" method="POST" class="form-inline">
          <input type="hidden" name="vessel_id" value= $vesselId>
            <div class="form-group">
              <label for="sailing_date" class="sr-only">開始時間:</label>
                <input type="date" class="form-control mr-2" id="sailing_date" name="sailing_date" required>
            </div>
             <div class="form-group">
               <label for="return_date" class="sr-only">結束時間:</label>
                <input type="date" class="form-control mr-2" id="return_date" name="return_date" required>
             </div>
             <button type="submit" class="btn btn-primary">送出</button>
         </form>
      </div>
    </div>
</div>
HTML;
}
else $fillPromiseShipment="";
//顯示可用船期
$availableShipment = "";
foreach ($data as $key => $value) {
    if (is_array($value)) {
        if (isset($value['available_sailing_date']) && isset($value['available_return_date'])) {
            $sailing_date = $value['available_sailing_date'];
            $return_date = $value['available_return_date'];
            $availableShipment .= <<<HTML
                $sailing_date ~ $return_date<br>
            HTML;
        }
    }
}
if (empty($availableShipment)) {
    $availableShipment = "尚未有船期";
}
if((isset($_GET['addAvailableShipment'])) && $_GET['addAvailableShipment'] == 1){ 
$vesselId = $data['id'];
$fillAvailableShipment = <<<HTML
<div class="container mt-1">
    <div class="row">
      <div class="col-12">
        <form id="shipmentForm" action="./?url=domesticShip/add-available-shipment" method="POST" class="form-inline">
          <input type="hidden" name="vessel_id" value= $vesselId>
            <div class="form-group">
              <label for="sailing_date" class="sr-only">開始時間:</label>
                <input type="date" class="form-control mr-2" id="sailing_date" name="sailing_date" required>
            </div>
             <div class="form-group">
               <label for="return_date" class="sr-only">結束時間:</label>
                <input type="date" class="form-control mr-2" id="return_date" name="return_date" required>
             </div>
             <button type="submit" class="btn btn-primary">送出</button>
         </form>
      </div>
    </div>
</div>
HTML;
}
else $fillAvailableShipment="";

// 顯示詳細規格
if (!empty($data['vessel_detail_id'])) {
  $category = $data['vessel_category_name'];
  $detail = <<<HTML
  <div class="card mt-4">
      <div class="card-header">
          $category 規格
      </div>
      <div class="card-body">
HTML;

  $startPrinting = false;
  foreach ($data as $key => $value) {
      if ($startPrinting && gettype($value) != "array") {
          $detail .= <<<HTML
          <div class="row mb-2">
              <div class="col-sm-6"><strong>$key</strong></div>
              <div class="col-sm-6">$value</div>
          </div>
HTML;
      }
      if ($key === "manufactured_country_flag_image_path") {
          $startPrinting = true;
      }
  }

  $detail .= <<<HTML
      </div>
  </div>
HTML;
} else {
  $detail = "";
}

//顯示下載規格書按鈕
$downloadButton = "";
if(empty($data['specification'])){
  $downloadButton = <<<HTML
    <div class="btn btn-secondary"   target="_blank">
        尚未上傳規格書 <i class="bi bi-file-earmark-arrow-down"></i>
    </div>
  HTML;
}
else{
  $downloadButton = <<<HTML
    <a href="./?url=domesticShip/download&id={$data['id']}&name={$data['name']}" class="btn btn-primary"  target="_blank">
      下載規格書 <i class="bi bi-file-earmark-arrow-down"></i>
    </a>
  HTML;
}
?>

<?php require APP_ROOT . 'views/include/header.php'; ?>
<?php require APP_ROOT . 'views/components/userNavBar.php'; ?>
<body>
  <div class="container my-4">
    <div class="col-12 mb-3" style="text-align: end; display: <?= $_SESSION['identity'] == 'wind_farm_develover' ? 'none' : 'block' ?>">
      <button class="btn btn-success bi bi-upload" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample1" aria-expanded="false" aria-controls="collapseExample">
        上傳資料
      </button>
      <a role="button" class="btn btn-warning ms-1" href=<?php echo "./?url=domesticShip/domestic-ship-information&ship_id=".$data['id']."&mode=updateShipment";?> >
        <i class="bi bi-pencil-square"></i> 船期編輯
      </a>
      <a role="button" class="btn btn-warning ms-1" href=<?php echo "./?url=domesticShip/domestic-ship-information&ship_id=".$data['id']."&mode=update";?> >
        <i class="bi bi-pencil-square"></i> 船舶規格編輯
      </a>
      <?= $downloadButton?>
    </div>
    <div class="col-12 mb-3" style="text-align: end">
    更新時間： <?=$data['updated_at']?> 
    </div>
    <div class="collapse" id="collapseExample1">
      <div class="row my-4">
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              <form action="./?url=domesticShip/upload&id=<?=$data['id']?>" method="post" enctype="multipart/form-data">
              <div class="row p-1">
                <div class="col-5">
                  <label for="formGroupExampleInput" class="form-label">船舶圖片 ( jpg, jpeg, png )</label>
                  <div class="input-group">
                    <input type="file" name="image" class="form-control" id="vesselImage">
                  </div>
                </div>
                <div class="col-5">
                  <label for="formGroupExampleInput" class="form-label">規格書( pdf )</label>
                  <div class="input-group">
                    <input type="file" name="specification" class="form-control" id="vesselSpecification">
                  </div>
                </div>
                <button type="submit" class="btn btn-success bi bi-upload mt-3">上傳</button>
              </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row mb-4">
      <div class="col-sm-12 mb-sm-1">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th class="table-primary col-4 pb-3 ps-3" scope="col">船名</th>
              <th class="table-primary col-4" scope="col">可用船期 &nbsp;&nbsp; 
              <a class="btn btn-outline-secondary" href="<?php echo './?url=domesticShip/domestic-ship-information&ship_id=' . $data['id'] . '&addAvailableShipment=1'; ?>" style="display: <?= $_SESSION['identity'] == 'wind_farm_develover' ? 'none' : 'inline-block' ?>">+</a>
              </th>
              <th class="table-primary col-4" scope="col">承諾船期 &nbsp;&nbsp; 
              <a class="btn btn-outline-secondary" href="<?php echo './?url=domesticShip/domestic-ship-information&ship_id=' . $data['id'] . '&addPromiseShipment=1'; ?>" style="display: <?= $_SESSION['identity'] == 'wind_farm_develover' ? 'none' : 'inline-block' ?>">+</a>
              </th>

            </tr>
          </thead>
          <tbody>
            <tr>
              <td><?=$data['name']?><br><img src="<?= $data['image'] ?? "" ?>" width="80%"/></td>
              <td><?php echo $availableShipment?>
              <?php echo $fillAvailableShipment?>
              </td>
              <td><?php echo $promiseShipment?>
              <?php echo $fillPromiseShipment?>
              </td>
              
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    
    <!-- General Information -->
    <div class="row mb-4">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            基本訊息
          </div>
          <div class="card-body">
            <div class="row mb-2">
              <div class="col-sm-3"><strong>船名</strong></div>
              <div class="col-sm-9"><?= $data['name'] ?></div>
            </div>
            <div class="row mb-2">
              <div class="col-sm-3"><strong>其他名稱</strong></div>
              <div class="col-sm-9"><?= $data['alias'] ?></div>
            </div>
            <div class="row mb-2">
              <div class="col-sm-3"><strong>船東</strong></div>
              <div class="col-sm-9"><?= $data['operator'] ?></div>
            </div>
            <div class="row mb-2">
              <div class="col-sm-3"><strong>船種</strong></div>
              <div class="col-sm-9"><?= $data['vessel_category_name'] ?></div>
            </div>
            <div class="row mb-2">
              <div class="col-sm-3"><strong>描述</strong></div>
              <div class="col-sm-9"><?=$data['description'] ?></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Identification and Operations Limits -->
    <div class="row mb-4">
    <div class="col-md-7">
        <div class="card">
          <div class="card-header">
            基本規格
          </div>
          <div class="card-body">
            <div class="row mb-2">
              <div class="col-sm-6"><strong>船長(m)</strong></div>
              <div class="col-sm-6"><?= $data['length'] ?></div>
            </div>
            <div class="row mb-2">
              <div class="col-sm-6"><strong>船寬(m)</strong></div>
              <div class="col-sm-6"><?= $data['breadth'] ?></div>
            </div>
            <div class="row mb-2">
              <div class="col-sm-6"><strong>船深(m)</strong></div>
              <div class="col-sm-6"><?= $data['depth'] ?></div>
            </div>
            <div class="row mb-2">
              <div class="col-sm-6"><strong>最小設計吃水(m)</strong></div>
              <div class="col-sm-6"><?= $data['draft_min'] ?></div>
            </div>
            <div class="row mb-2">
              <div class="col-sm-6"><strong>最大設計吃水(m)</strong></div>
              <div class="col-sm-6"><?= $data['draft_max'] ?></div>
            </div>
            <div class="row mb-2">
              <div class="col-sm-6"><strong>巡航速度(kt)</strong></div>
              <div class="col-sm-6"><?= $data['transitSpeed'] ?></div>
            </div>
            <div class="row mb-2">
              <div class="col-sm-6"><strong>最大速度(kt)</strong></div>
              <div class="col-sm-6"><?= $data['speed_max'] ?></div>
            </div>
            <div class="row mb-2">
              <div class="col-sm-6"><strong>空閒甲板面積(m^2)</strong></div>
              <div class="col-sm-6"><?= $data['freeDeckSpace'] ?></div>
            </div>
            <div class="row mb-2">
              <div class="col-sm-6"><strong>甲板承載力(t/m^2)</strong></div>
              <div class="col-sm-6"><?= $data['deck_load_max'] ?></div>
            </div>
            <div class="row mb-2">
              <div class="col-sm-6"><strong>載重量(t)</strong></div>
              <div class="col-sm-6"><?= $data['capacity_weigth'] ?></div>
            </div>
            <div class="row mb-2">
              <div class="col-sm-6"><strong>動態定位(DPCClass)</strong></div>
              <div class="col-sm-6"><?= $data['DPC_class'] ?></div>
            </div>
          </div>
        </div>
      </div>
      <!-- Identification -->
      <div class="col-md-5 mb-4 mb-md-0">
        <div class="card">
          <div class="card-header">
            識別資訊
          </div>
          <div class="card-body">
            <div class="row mb-2">
              <div class="col-sm-3"><strong>MMSI</strong></div>
              <div class="col-sm-9"><?= $data['mmsi'] ?></div>
            </div>
            <div class="row mb-2">
              <div class="col-sm-3"><strong>IMO</strong></div>
              <div class="col-sm-9"><?= $data['imo'] ?></div>
            </div>
            <div class="row mb-2">
              <div class="col-sm-3"><strong>國籍</strong></div>
              <div class="col-sm-9"><?= $data['country_name'] ?></div>
            </div>
          </div>
        </div>
        <div class="row mt-2 mb-4">
            <div class="col-md-12">
                <div class="card">
                <div class="card-header">
                  建造資訊
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                    <div class="col-sm-3"><strong>造船廠</strong></div>
                    <div class="col-sm-9"><?= $data['shipyard'] ?></div>
                    </div>
                    <div class="row mb-2">
                    <div class="col-sm-3"><strong>造船國</strong></div>
                    <div class="col-sm-9"><?= $data['manufactured_country_name'] ?></div>
                    </div>
                    <div class="row mb-2">
                    <div class="col-sm-3"><strong>建造日期</strong></div>
                    <div class="col-sm-9"><?= $data['manufactured_at_year'] ?></div>
                    </div>
                    <div class="row mb-2">
                    <div class="col-sm-3"><strong>船級</strong></div>
                    <div class="col-sm-9"><?= $data['ship_class'] ?></div>
                    </div>
                </div>
                </div>
            </div>
        </div>
      </div>
        <!-- Operations Limits -->
        <div>
          <?php echo $detail;?>
        </div>
      </div>
  </div>
</body>
