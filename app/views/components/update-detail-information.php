<?php
$detail = "";
$specIndex = 1;
// 處理詳細規格
if (!empty($data['vessel_detail_id'])) {
  $startPrinting = false;
  foreach ($data as $key => $value) {
      if ($startPrinting && gettype($value) != "array") {
        $detail .= <<<HTML
        <label for="other_device" class="col-sm-3 col-form-label">$key</label>
        <div class="col-sm-9 mt-2">
            <input type="text" class="form-control" id="specification_$specIndex" name="specification_$specIndex" value="$value">
        </div>
HTML;
          $specIndex++; // 更新索引
      }
      if ($key === "manufactured_country_flag_image_path") {
          $startPrinting = true;
      }
  }
} else {
  $detail = "";
}
?>
<div class="col-md-6 ms-5">
    <div class="header p-2"><strong><?= $data['vessel_category_name'] ?>規格</strong></div>
    <div class="form-group row">
        <?= $detail ?>
    </div>
</div>
