<?php
$startPrinting = false;
$detail = "";
$specIndex = 1; // 初始化索引
foreach ($data as $key => $value) {
    if ($startPrinting) {
        $detail .= <<<HTML
        <label for="other_device" class="col-sm-3 col-form-label">$key</label>
        <div class="col-sm-9 mt-2">
            <input type="text" class="form-control" id="specification_$specIndex" name="specification_$specIndex">
        </div>
        HTML;
        $specIndex++;
    }
    else{
        $detail .= <<<HTML
        <input type="hidden" name="$key" value="$value">
        HTML;
    }
    if ($key === "vessel_detail_id") {
        $startPrinting = true;
    }
}
?>
<div class="col-md-6 ms-5">
  <h5 class="py-3"><?= $data['vessel_category_name']?>規格</h5>
  <div class="form-group row">
      <?=$detail?>
  </div>
</div>
</div>