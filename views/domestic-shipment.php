<?php
$html = <<<HTML
<div class="mt-4">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="table-primary" scope="col">船名</th>
                <th class="table-primary" scope="col">可用船期</th>
                <th class="table-primary" scope="col">承諾船期</th>
            </tr>
        </thead>
        <tbody>
HTML;

foreach ($data as $vesselName => $schedules) {
    $availableSchedules = [];
    $promiseSchedules = [];
    
    foreach ($schedules as $schedule) {
        if (isset($schedule['available_sailing_date'])) {
            $availableSchedules[] = "{$schedule['available_sailing_date']} ~ {$schedule['available_return_date']}";
        } elseif (isset($schedule['promise_sailing_date'])) {
            $promiseSchedules[] = "{$schedule['promise_sailing_date']} ~ {$schedule['promise_return_date']}";
        }
    }
    
    $availableScheduleText = empty($availableSchedules) ? "尚未有船期" : implode('<br>', $availableSchedules);
    $promiseScheduleText = empty($promiseSchedules) ? "尚未有船期" : implode('<br>', $promiseSchedules);

    $html .= <<<HTML
        <tr>
            <td>{$vesselName}</td>
            <td>{$availableScheduleText}</td>
            <td>{$promiseScheduleText}</td>
        </tr>
HTML;
}

$html .= <<<HTML
        </tbody>
    </table>
</div>
HTML;
?>
<?php require APP_ROOT . 'views/include/header.php'; ?>
<body>
<?php require APP_ROOT . 'views/components/userNavBar.php'; ?>
<div class="container my-4">
  <div class="row mb-4">
    <div class="col-12" style="text-align: end">
        <button type="submit" form="vesselForm" class="btn btn-primary ms-1">
            <i class="bi bi-printer"> </i>列印PDF
        </button>
    </div>
    <div class="col-sm-12 mb-sm-1">
        <?=$html?>
    </div>
    <form id="vesselForm" action="./?url=domesticShip/shipment-print" method="POST">
        <input type="hidden" name="html" value="<?php echo htmlentities($html);?>">
        <input type="hidden" name="category" value="<?php echo $_GET['category_name'];?>">
    </form>
  </div>
</div>
