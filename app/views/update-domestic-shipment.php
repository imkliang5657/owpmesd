<?php
$promiseSchedules = [];
$availableSchedules = [];
$number = 0;
foreach ($data as $schedule) {
    if (isset($schedule['promise_shipping_schedules_id'])) {
        $promiseSchedules[] = $schedule;
    } elseif (isset($schedule['available_shipping_schedules_id'])) {
        $availableSchedules[] = $schedule;
    }
}
$promiseShipment = <<<HTML
    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="table-primary" scope="col">承諾船期筆數</th>
                <th class="table-primary" scope="col">開始船期</th>
                <th class="table-primary" scope="col">結束船期</th>
            </tr>
        </thead>
        <tbody>
HTML;
$number = 0;
foreach ($promiseSchedules as $schedule) {
    $number++;
    $id = $schedule['promise_shipping_schedules_id'];
    $sailing_date = $schedule['promise_sailing_date'];
    $return_date = $schedule['promise_return_date'];
    $promiseShipment .= <<<HTML
            <tr>
                <td >第 $number 筆</td>
                <input type="hidden" name="promise_shipping_schedules_id[]" value="$id">
                <input type="hidden"  class="form-control" name="origin_promise_sailing_date[]" value="$sailing_date">
                <input type="hidden"  class="form-control" name="origin_promise_return_date[]" value="$return_date">
                <td><input type="date"  class="form-control" name="promise_sailing_date[]" value="$sailing_date"></td>
                <td><input type="date"  class="form-control" name="promise_return_date[]" value="$return_date"></td>
            </tr>
HTML;
}

$promiseShipment .= <<<HTML
        </tbody>
    </table>
HTML;

// 生成 available 船期表格
$availableShipment = <<<HTML
    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="table-primary" scope="col">可用船期筆數</th>
                <th class="table-primary" scope="col">開始船期</th>
                <th class="table-primary" scope="col">結束船期</th>
            </tr>
        </thead>
        <tbody>
HTML;
$number = 0;
foreach ($availableSchedules as $schedule) {
    $number++;
    $id = $schedule['available_shipping_schedules_id'];
    $sailing_date = $schedule['available_sailing_date'];
    $return_date = $schedule['available_return_date'];
    $availableShipment .= <<<HTML
            <tr>
                <td>第 $number 筆</td>
                <input type="hidden" name="available_shipping_schedules_id[]" value="$id">
                <input type="hidden" class="form-control" name="origin_available_sailing_date[]" value="$sailing_date">
                <input type="hidden" class="form-control" name="origin_available_return_date[]" value="$return_date">
                <td><input type="date" class="form-control" name="available_sailing_date[]" value="$sailing_date"></td>
                <td><input type="date" class="form-control" name="available_return_date[]" value="$return_date"></td>
            </tr>
HTML;
}

$availableShipment .= <<<HTML
        </tbody>
    </table>
HTML;


?>

<?php require APP_ROOT . 'views/include/header.php';?>
<body>
  <?php require APP_ROOT . 'views/components/userNavBar.php';?>
  <div class="container my-5">
    <div class="row">
      <div class="col-sm-12 mb-3 mb-sm-4">
        <div class="card p-2">
          <div class="card-body">
          <div class="col-12" style="text-align: end">
                <button type="submit" form="vesselForm" class="btn btn-warning ms-1">
                    <i class="bi bi-pencil-square"> </i>確定更新
                </button>
            </div>
          <form id="vesselForm" action="./?url=domesticShip/update-domestic-shipment" method="POST">
            <input type="hidden" name="vessel_id" value=<?=$_GET['ship_id']?>>
            <div class="mt-3">
                <?=$promiseShipment;?>
            </div>
            <div class ="mt-3">
                <?=$availableShipment;?>
            </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>