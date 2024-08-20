<?php
$vesselCategoryOptions = '<option selected value="">全部</option>';
foreach ($data['vesselCategories'] as $vesselCategory) {
    $selected = isset($_GET['vesselCategoryId']) && $vesselCategory['id'] == $_GET['vesselCategoryId'] ? 'selected' : '';
    $vesselCategoryOptions .= <<< HTML
      <option value="{$vesselCategory['id']}" {$selected}>{$vesselCategory['vessel_category_name']}</option>
    HTML;
}

$options = [">", ">=", "=", "<=", "<"];
$optionNames = ["大於", "大於等於", "等於", "小於等於", "小於"];

function generateOptions($parameterName, $options, $optionNames): string
{
    $optionsHtml = '<option value="IS" selected></option>';
    foreach ($options as $index => $option) {
        $selected = isset($_GET[$parameterName]) && $option == $_GET[$parameterName] ? 'selected' : '';
        $optionsHtml .= <<<HTML
          <option value="{$option}" {$selected}>{$optionNames[$index]}</option>
        HTML;
    }
    return $optionsHtml;
}

$conditionOfLengthOptions = generateOptions('condition_of_length', $options, $optionNames);
$conditionOfBreadthOptions = generateOptions('condition_of_breadth', $options, $optionNames);
$conditionOfDepthOptions = generateOptions('condition_of_depth', $options, $optionNames);
$conditionOfCraneWeightOptions = generateOptions('condition_of_crane_weight', $options, $optionNames);
$conditionOfCableCapacityOptions = generateOptions('condition_of_cable_capacity', $options, $optionNames);
$conditionOfBollardPullForceOptions = generateOptions('condition_of_bollard_pull_force', $options, $optionNames);
$conditionOfFreeDeckSpaceOptions = generateOptions('condition_of_freeDeckSpace', $options, $optionNames);
$conditionOfOperatingDraftOptions = generateOptions('condition_of_operating_draft', $options, $optionNames);
$conditionOfDraftMinOptions = generateOptions('condition_of_draft_min', $options, $optionNames);

function generateTableCell($queryParams, $key, $value): string
{
    return !empty($queryParams[$key]) ? "<td>{$value}</td>" : "";
}

$tbodyContent = "";
foreach ($data['vessels'] as $vessel) {
    $tbodyContent .= <<<HTML
    <tr>
      <td>
        <a href="./?url=domesticShip/domestic-ship-information&ship_id={$vessel['id']}" class="link-primary">{$vessel['name']}</a>
      </td>
      <td>{$vessel['vessel_category_name']}</td>
      <td>{$vessel['country']}</td>
    HTML;
    $tbodyContent .= generateTableCell($_GET, 'length', $vessel['length']);
    $tbodyContent .= generateTableCell($_GET, 'breadth', $vessel['breadth']);
    $tbodyContent .= generateTableCell($_GET, 'depth', $vessel['depth']);
    $tbodyContent .= generateTableCell($_GET, 'crane_weight', $vessel['crane_weight']);
    $tbodyContent .= generateTableCell($_GET, 'cable_capacity', $vessel['cable_capacity']);
    $tbodyContent .= generateTableCell($_GET, 'bollard_pull_force', $vessel['bollard_pull_force']);
    $tbodyContent .= generateTableCell($_GET, 'freeDeckSpace', $vessel['freeDeckSpace']);
    $tbodyContent .= generateTableCell($_GET, 'operating_draft', $vessel['operating_draft']);
    $tbodyContent .= generateTableCell($_GET, 'draft_min', $vessel['draft_min']);
    $tbodyContent .= "</tr>";
}

?>

<?php require APP_ROOT . 'views/include/header.php';?>
<body>
<?php require APP_ROOT . 'views/components/userNavBar.php';?>
<div class="container my-5">
    <form method="get">
      <input type="hidden" name="url" value="page/search-vessel">
      <div class="row mt-2">
          <div class="col-sm-12 mb-4 mb-sm-4">
              <div class="card p-2">
                  <div class="card-body">
                      <div class="row my-3">
                          <div class="col-9">
                              <h3 class="card-title">搜尋條件</h3>
                          </div>
                          <div class="col-3" style="text-align: end">
                              <button class="btn btn-warning" type="submit" id="button-addon2">
                                  <i class="bi bi-search"></i> 查詢
                              </button>
                              <a href=".?url=page/search-vessel" class="btn btn-danger" tabindex="-1" role="button">重置條件</a>
                          </div>
                      </div>
                      <div class="row my-3 mt-4">
                          <div class="col-sm-3">
                              <div class="input-group">
                                  <span class="input-group-text" id="basic-addon1">船名</span>
                                  <input type="text" class="form-control" name="vesselName" value="<?= $_GET['vesselName'] ?? NULL ?>">
                              </div>
                          </div>
                          <div class="col-sm-3">
                              <div class="input-group">
                                  <span class="input-group-text" id="basic-addon1">IMO</span>
                                  <input type="text" class="form-control" name="imo" value="<?= $_GET['imo'] ?? NULL ?>">
                              </div>
                          </div>
                          <div class="col-sm-3">
                            <div class="input-group">
                              <span class="input-group-text" id="basic-addon1">MMSI</span>
                              <input type="text" class="form-control" name="mmsi" value="<?= $_GET['mmsi'] ?? NULL ?>">
                            </div>
                          </div>
                      </div>
                      <div class="row my-3 mb-5">
                          <div class="col-sm-7">
                              <div class="input-group">
                                  <span class="input-group-text" id="basic-addon1">船種</span>
                                  <select class="form-select" aria-label="Default select example" name="vesselCategoryId">
                                    <?= $vesselCategoryOptions ?>
                                  </select>
                              </div>
                          </div>
                      </div>
                    <div class="row my-3">
                      <div class="col-sm-10">
                        <div class="input-group">
                          <span class="input-group-text">船長</span>
                          <select class="form-select" name="condition_of_length">
                              <?= $conditionOfLengthOptions ?>
                          </select>
                          <input type="number" class="form-control" placeholder="請輸入船長" name="length" value="<?= $_GET['length'] ?? NULL ?>">
                          <span class="input-group-text">M</span>
                        </div>
                      </div>
                    </div>
                    <div class="row my-3">
                      <div class="col-sm-10">
                        <div class="input-group">
                          <span class="input-group-text">船寬</span>
                          <select class="form-select" name="condition_of_breadth">
                            <?= $conditionOfBreadthOptions ?>
                          </select>
                          <input type="number" class="form-control" placeholder="請輸入船寬" name="breadth" value="<?= $_GET['breadth'] ?? NULL ?>">
                          <span class="input-group-text">M</span>
                        </div>
                      </div>
                    </div>
                    <div class="row my-3">
                      <div class="col-sm-10">
                        <div class="input-group">
                          <span class="input-group-text">船深</span>
                          <select class="form-select" name="condition_of_depth">
                              <?= $conditionOfDepthOptions ?>
                          </select>
                          <input type="number" class="form-control" placeholder="請輸入船深" name="depth" value="<?= $_GET['depth'] ?? NULL ?>">
                          <span class="input-group-text">M</span>
                        </div>
                      </div>
                    </div>
                      <div class="row my-3">
                          <div class="col-sm-10">
                              <div class="input-group">
                                  <span class="input-group-text">最大吊重能力</span>
                                  <select class="form-select" name="condition_of_crane_weight">
                                      <?= $conditionOfCraneWeightOptions ?>
                                  </select>
                                  <input type="number" class="form-control" placeholder="請輸入最大吊重" name="crane_weight" value="<?= $_GET['crane_weight'] ?? NULL ?>">
                                  <span class="input-group-text">T</span>
                              </div>
                          </div>
                      </div>
                      <div class="row my-3">
                          <div class="col-sm-10">
                              <div class="input-group">
                                  <span class="input-group-text">盤纜槽裝載量</span>
                                    <select class="form-select" name="condition_of_cable_capacity">
                                        <?= $conditionOfCableCapacityOptions ?>
                                    </select>
                                  <input type="number" class="form-control" placeholder="請輸入盤纜槽裝載量" name="cable_capacity" value="<?= $_GET['cable_capacity'] ?? NULL ?>">
                                  <span class="input-group-text">T</span>
                              </div>
                          </div>
                      </div>
                      <div class="row my-3">
                        <div class="col-sm-10">
                          <div class="input-group">
                            <span class="input-group-text">繫纜拖力</span>
                            <select class="form-select" name="condition_of_bollard_pull_force">
                                <?= $conditionOfBollardPullForceOptions ?>
                            </select>
                            <input type="number" class="form-control" placeholder="請輸入繫纜拖力" name="bollard_pull_force" value="<?= $_GET['bollard_pull_force'] ?? NULL ?>">
                            <span class="input-group-text">T</span>
                          </div>
                        </div>
                      </div>
                      <div class="row my-3">
                        <div class="col-sm-10">
                          <div class="input-group">
                            <span class="input-group-text">空閒甲板面積</span>
                            <select class="form-select" name="condition_of_freeDeckSpace">
                                <?= $conditionOfFreeDeckSpaceOptions ?>
                            </select>
                            <input type="number" class="form-control" placeholder="請輸入空閒甲板面積" name="freeDeckSpace" value="<?= $_GET['freeDeckSpace'] ?? NULL ?>">
                            <span class="input-group-text">M^2</span>
                          </div>
                        </div>
                      </div>
                      <div class="row my-3">
                        <div class="col-sm-10">
                          <div class="input-group">
                            <span class="input-group-text">操作水深</span>
                            <select class="form-select" name="condition_of_operating_draft">
                                <?= $conditionOfOperatingDraftOptions ?>
                            </select>
                            <input type="number" class="form-control" placeholder="請輸入作業水深" name="operating_draft" value="<?= $_GET['operating_draft'] ?? NULL ?>">
                            <span class="input-group-text">M</span>
                          </div>
                        </div>
                      </div>
                      <div class="row my-3">
                        <div class="col-sm-10">
                          <div class="input-group">
                            <span class="input-group-text">最小設計吃水</span>
                            <select class="form-select" name="condition_of_draft_min">
                                <?= $conditionOfDraftMinOptions ?>
                            </select>
                            <input type="number" class="form-control" placeholder="請輸入最小設計吃水" name="draft_min" value="<?= $_GET['draft_min'] ?? NULL ?>">
                            <span class="input-group-text">M</span>
                          </div>
                        </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
    </form>
    <div class="row">
      <div class="col-sm-12 mb-3 mb-sm-4">
        <div class="card p-2">
          <div class="card-body">
            <div class="row">
              <div class="col-9">
                <h3 class="card-title mb-3">查詢結果</h3>
              </div>
            </div>
            <table class="table table-bordered mt-3">
              <thead>
              <tr>
                <th class="table-primary" scope="col">船名</th>
                <th class="table-primary" scope="col">船種</th>
                <th class="table-primary" scope="col">所屬國家</th>
                <th class="table-primary" scope="col" style="<?= empty($_GET['length']) ? "display: none" : "" ?>">船長</th>
                <th class="table-primary" scope="col" style="<?= empty($_GET['breadth']) ? "display: none" : "" ?>">船寬</th>
                <th class="table-primary" scope="col" style="<?= empty($_GET['depth']) ? "display: none" : "" ?>">船深</th>
                <th class="table-primary" scope="col" style="<?= empty($_GET['crane_weight']) ? "display: none" : "" ?>">最大吊重能力</th>
                <th class="table-primary" scope="col" style="<?= empty($_GET['cable_capacity']) ? "display: none" : "" ?>">盤纜槽裝載量</th>
                <th class="table-primary" scope="col" style="<?= empty($_GET['bollard_pull_force']) ? "display: none" : "" ?>">繫纜拖力</th>
                <th class="table-primary" scope="col" style="<?= empty($_GET['freeDeckSpace']) ? "display: none" : "" ?>">空閒甲板面積</th>
                <th class="table-primary" scope="col" style="<?= empty($_GET['operating_draft']) ? "display: none" : "" ?>">操作水深</th>
                <th class="table-primary" scope="col" style="<?= empty($_GET['draft_min']) ? "display: none" : "" ?>">最小設計吃水</th>
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
</body>
