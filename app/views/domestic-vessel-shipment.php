<?php
$displayTable = <<<HTML
<table class="table table-bordered">
          <thead>
            <tr>
              <th class="table-primary" scope="col">船名</th>
              <th class="table-primary" scope="col">已使用船期</th>
            </tr>
          </thead>
HTML;
$displayTable .= "<tbody>";
foreach ($data as $ship) {
    $displayTable .= "<tr>";
    $displayTable .= "<td>" . htmlspecialchars($ship['name']) . "</td>";
    if (!empty($ship['start_shipment_time']) && !empty($ship['end_shipment_time'])) {
        $displayTable .= "<td>" . htmlspecialchars($ship['start_shipment_time']) . " ~ " . htmlspecialchars($ship['end_shipment_time']) . "</td>";
    } else {
        $displayTable .= "<td>沒有船期</td>";
    }
    $displayTable .= "</tr>";
}
$displayTable .= "</tbody>";

$displayTable .= "</table>";
?>
<?php require APP_ROOT . 'views/include/header.php'; ?>
<body>
<?php require APP_ROOT . 'views/components/userNavBar.php'; ?>
<div class="container my-4">
    <div class="row mb-4">
        <div class="col-sm-12 mb-sm-1">
            <?= $displayTable?>
        </div>
    </div>
</div>
