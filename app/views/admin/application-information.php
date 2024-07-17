<?php
$stage_display = [true, false, false];
$stage_disabled = [false, false, false];
$stage_background_color = ['', '', '', ''];
switch ($data['status']) {
    case '通過':
        $stage_disabled[2] = true;
        $stage_background_color[2] = 'bg-dark-subtle';
    case '審查會議':
        $stage_display[2] = true;
        $stage_disabled[1] = true;
        $stage_background_color[1] = 'bg-dark-subtle';
    case '會議準備':
        $stage_display[1] = true;
        $stage_disabled[0] = true;
        $stage_background_color[0] = 'bg-dark-subtle';
}

?>

<?php
if (!empty($data['vessel_detail_id'])) {
    $category = $data['vessel_category_name'];
    $detail = <<< HTML
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
    $detail .= "</div></div>";
} else {
    $detail = "";
}
?>

<?php require APP_ROOT . 'views/include/header.php'; ?>
<?php require APP_ROOT . 'views/components/userNavBar.php'; ?>
<body>
<div class="container mt-5">
  <button class="btn btn-warning" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample1" aria-expanded="false" aria-controls="collapseExample">
    顯示申請案資訊
  </button>
  <button class="btn btn-warning" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample2" aria-expanded="false" aria-controls="collapseExample">
    顯示外籍船舶資訊
  </button>
  <div class="collapse" id="collapseExample1">
    <div class="row my-4">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            基本資料
          </div>
          <div class="card-body">
            <div class="row mb-2">
              <div class="col-sm-3"><strong>申請案狀態</strong></div>
              <div class="col-sm-9"><?= $data['status'] ?></div>
            </div>
            <div class="row mb-2">
              <div class="col-sm-3"><strong>申請公司</strong></div>
              <div class="col-sm-9"><?= $data['applicant'] ?></div>
            </div>
            <div class="row mb-2">
              <div class="col-sm-3"><strong>風場</strong></div>
              <div class="col-sm-9"><?= $data['wind_farm'] ?></div>
            </div>
            <div class="row mb-2">
              <div class="col-sm-3"><strong>工作項目</strong></div>
              <div class="col-sm-9"><?= $data['work_item'] ?></div>
            </div>
            <div class="row mb-2">
              <div class="col-sm-3"><strong>描述</strong></div>
              <div class="col-sm-9"><?= $data['description'] ?></div>
            </div>
            <div class="row mb-2">
              <div class="col-sm-3"><strong>使用船期</strong></div>
              <div class="col-sm-9"><?= $data['required_sailing_date'] ?> 至 <?= $data['required_return_date'] ?></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="collapse" id="collapseExample2">
    <div class="row my-4">
      <div class="col-md-7">
        <div class="card">
          <div class="card-header">
            基本規格
          </div>
          <div class="card-body">
            <div class="row mb-2">
              <div class="col-sm-6"><strong>船長(M)</strong></div>
              <div class="col-sm-6"><?= $data['foreign_vessel']['length'] ?></div>
            </div>
            <div class="row mb-2">
              <div class="col-sm-6"><strong>船寬(M)</strong></div>
              <div class="col-sm-6"><?= $data['foreign_vessel']['breadth'] ?></div>
            </div>
            <div class="row mb-2">
              <div class="col-sm-6"><strong>船深(M)</strong></div>
              <div class="col-sm-6"><?= $data['foreign_vessel']['depth'] ?></div>
            </div>
            <div class="row mb-2">
              <div class="col-sm-6"><strong>最小設計吃水(M)</strong></div>
              <div class="col-sm-6"><?= $data['foreign_vessel']['draft_min'] ?></div>
            </div>
            <div class="row mb-2">
              <div class="col-sm-6"><strong>最大設計吃水(m)</strong></div>
              <div class="col-sm-6"><?= $data['foreign_vessel']['draft_max'] ?></div>
            </div>
            <div class="row mb-2">
              <div class="col-sm-6"><strong>巡航速度(KT)</strong></div>
              <div class="col-sm-6"><?= $data['foreign_vessel']['transitSpeed'] ?></div>
            </div>
            <div class="row mb-2">
              <div class="col-sm-6"><strong>最大速度(KT)</strong></div>
              <div class="col-sm-6"><?= $data['foreign_vessel']['speed_max'] ?></div>
            </div>
            <div class="row mb-2">
              <div class="col-sm-6"><strong>空閒甲板面積(M^2)</strong></div>
              <div class="col-sm-6"><?= $data['foreign_vessel']['freeDeckSpace'] ?></div>
            </div>
            <div class="row mb-2">
              <div class="col-sm-6"><strong>甲板承載力(T/M^2)</strong></div>
              <div class="col-sm-6"><?= $data['foreign_vessel']['deck_load_max'] ?></div>
            </div>
            <div class="row mb-2">
              <div class="col-sm-6"><strong>載重量(T)</strong></div>
              <div class="col-sm-6"><?= $data['foreign_vessel']['capacity_weigth'] ?></div>
            </div>
            <div class="row mb-2">
              <div class="col-sm-6"><strong>動態定位(DPCClass)</strong></div>
              <div class="col-sm-6"><?= $data['foreign_vessel']['DPC_class'] ?></div>
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
              <div class="col-sm-3"><strong>船名</strong></div>
              <div class="col-sm-6"><?= $data['foreign_vessel']['name'] ?></div>
            </div>
            <div class="row mb-2">
              <div class="col-sm-3"><strong>MMSI</strong></div>
              <div class="col-sm-9"><?= $data['foreign_vessel']['mmsi'] ?></div>
            </div>
            <div class="row mb-2">
              <div class="col-sm-3"><strong>IMO</strong></div>
              <div class="col-sm-9"><?= $data['foreign_vessel']['imo'] ?></div>
            </div>
            <div class="row mb-2">
              <div class="col-sm-3"><strong>國籍</strong></div>
              <div class="col-sm-9"><?= $data['foreign_vessel']['country_name'] ?></div>
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
                  <div class="col-sm-9"><?= $data['foreign_vessel']['shipyard'] ?></div>
                </div>
                <div class="row mb-2">
                  <div class="col-sm-3"><strong>造船國</strong></div>
                  <div class="col-sm-9"><?= $data['foreign_vessel']['manufactured_country_name'] ?></div>
                </div>
                <div class="row mb-2">
                  <div class="col-sm-3"><strong>建造日期</strong></div>
                  <div class="col-sm-9"><?= $data['foreign_vessel']['manufactured_at_year'] ?></div>
                </div>
                <div class="row mb-2">
                  <div class="col-sm-3"><strong>船級</strong></div>
                  <div class="col-sm-9"><?= $data['foreign_vessel']['ship_class'] ?></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div>
          <?php echo $detail;?>
      </div>
    </div>
  </div>
  <div class="row my-4">
    <div class="col-md-12">
      <div class="card <?= $stage_background_color[0] ?>">
        <div class="card-header">
          <div class="row align-items-center">
            <div class="col-9 mt-2">
              <h6>第一階段</h6>
            </div>
            <div class="col-3" style="text-align: end">
              <a class="btn btn-danger <?= $stage_disabled[0] ? 'disabled' : '' ?>"
                 href="?url=applications/application/reject&id=<?= $data['id'] ?>" role="button">
                退件 <i class="bi bi-ban-fill"></i>
              </a>
              <a class="btn btn-success <?= $stage_disabled[0] ? 'disabled' : '' ?>"
                 href="?url=applications/application/approve-pretrial&id=<?= $data['id'] ?>" role="button">
                通過 <i class="bi bi-check-circle-fill"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row my-4" style="display: <?= $stage_display[1] ? 'display' : 'none' ?>">
    <form id="form2" action="?url=applications/application/conference-held&id=<?= $data['id'] ?>" method="post" enctype="multipart/form-data">
      <div class="col-md-12">
        <div class="card <?= $stage_background_color[1] ?>">
          <div class="card-header">
            <div class="row align-items-center">
              <div class="col-1 mt-2">
                <h6>第二階段</h6>
              </div>
              <div class="col-8">
                <div class="progress my-2" style="<?= $stage_display[2] ? 'visibility: hidden' : '' ?>" role="progressbar">
                  <div id="progressBar2" class="progress-bar bg-secondary progress-bar-striped progress-bar-animated" style="width: 0%">0%</div>
                </div>
              </div>
              <div class="col-3" style="text-align: end">
                <button type="submit" class="btn btn-success <?= $stage_disabled[1] ? 'disabled' : '' ?>">
                  會議舉行 <i class="bi bi-check-circle-fill"></i>
                </button>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="row p-1">
              <div class="col-5">
                <div class="my-2">
                  <label for="formGroupExampleInput" class="form-label">能源署函號</label>
                  <input name="official_document_number" type="text" class="form-control" id="formGroupExampleInput" required
                         value="<?= $data['official_document_number'] ?>" placeholder="函號" <?= $stage_disabled[1] ? 'disabled' : '' ?>>
                </div>
              </div>
              <div class="col-5">
                <div class="my-2">
                  <label for="formGroupExampleInput" class="form-label">申請函文</label>
                  <div class="input-group">
                    <span class="input-group-text" id="addon-wrapping" style="display: <?= $stage_display[2] ? 'display' : 'none' ?>">
                        <?= $data['files']['conference_notice']['created_at'] ?>
                    </span>
                    <span class="input-group-text" id="addon-wrapping" style="display: <?= $stage_display[2] ? 'display' : 'none' ?>">
                        <?= explode("/", $data['files']['application_letter']['name'])[4] ?>
                    </span>
                    <input type="file" name="application_letter" class="form-control" required id="inputGroupFile01" style="display: <?= $stage_disabled[1] ? 'none' : 'display' ?>">
                    <a href="<?= $data['files']['application_letter']['name'] ?? "" ?>" class="btn btn-secondary <?= !$stage_disabled[1] ? 'disabled' : '' ?>" role="button" target="_blank">
                      下載 <i class="bi bi-file-earmark-arrow-down"></i>
                    </a>
                  </div>
                </div>
              </div>
              <div class="col-5">
                <div class="my-2">
                  <label for="formGroupExampleInput" class="form-label">開會通知單</label>
                  <div class="input-group">
                    <span class="input-group-text" id="addon-wrapping" style="display: <?= $stage_display[2] ? 'display' : 'none' ?>">
                        <?= $data['files']['conference_notice']['created_at'] ?>
                    </span>
                    <span class="input-group-text" id="addon-wrapping" style="display: <?= $stage_display[2] ? 'display' : 'none' ?>">
                        <?= explode("/", $data['files']['conference_notice']['name'])[4] ?>
                    </span>
                    <input type="file" name="conference_notice" class="form-control" required id="inputGroupFile01" style="display: <?= $stage_disabled[1] ? 'none' : 'display' ?>">
                    <a href="<?= $data['files']['conference_notice']['name'] ?? "" ?>" class="btn btn-secondary <?= !$stage_disabled[1] ? 'disabled' : '' ?>" role="button" target="_blank">
                      下載 <i class="bi bi-file-earmark-arrow-down"></i>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
  <div class="row my-4" style="display: <?= $stage_display[2] ? 'display' : 'none' ?>">
    <form id="form4" action="?url=applications/application/close&id=<?= $data['id'] ?>" method="post" enctype="multipart/form-data">
      <div class="col-md-12">
        <div class="card <?= $stage_background_color[2] ?>">
          <div class="card-header">
            <div class="row align-items-center">
              <div class="col-1 mt-2">
                <h6>第三階段</h6>
              </div>
              <div class="col-8">
                <div class="progress my-2" style="<?= $stage_disabled[2] ? 'visibility: hidden' : '' ?>" role="progressbar">
                  <div id="progressBar4" class="progress-bar bg-secondary progress-bar-striped progress-bar-animated" style="width: 0%">0%</div>
                </div>
              </div>
              <div class="col-3" style="text-align: end">
                <button type="submit" class="btn btn-success <?= $stage_disabled[2] ? 'disabled' : '' ?>">
                  通過 <i class="bi bi-check-circle-fill"></i>
                </button>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="row p-1">
              <div class="col-5">
                <div class="my-2">
                  <label for="formGroupExampleInput" class="form-label">會議記錄</label>
                  <div class="input-group">
                    <span class="input-group-text" id="addon-wrapping" style="display: <?= $stage_disabled[2] ? 'display' : 'none' ?>">
                        <?= $data['files']['conference_record']['created_at'] ?>
                    </span>
                    <span class="input-group-text" id="addon-wrapping" style="display: <?= $stage_disabled[2] ? 'display' : 'none' ?>">
                        <?= explode("/", $data['files']['conference_record']['name'])[4] ?>
                    </span>
                    <input type="file" name="conference_record" class="form-control" id="inputGroupFile01" required style="display: <?= $stage_disabled[2] ? 'none' : 'display' ?>">
                    <a href="<?= $data['files']['conference_record']['name'] ?? "" ?>" class="btn btn-secondary <?= !$stage_disabled[2] ? 'disabled' : '' ?>" role="button" target="_blank">
                      下載 <i class="bi bi-file-earmark-arrow-down"></i>
                    </a>
                  </div>
                </div>
              </div>
              <div class="col-5">
                <div class="my-2">
                  <label for="formGroupExampleInput" class="form-label">同意函</label>
                  <div class="input-group">
                    <span class="input-group-text" id="addon-wrapping" style="display: <?= $stage_disabled[2] ? 'display' : 'none' ?>">
                        <?= $data['files']['consent_letter']['created_at'] ?>
                    </span>
                    <span class="input-group-text" id="addon-wrapping" style="display: <?= $stage_disabled[2] ? 'display' : 'none' ?>">
                        <?= explode("/", $data['files']['consent_letter']['name'])[4] ?>
                    </span>
                    <input type="file" name="consent_letter" class="form-control" id="inputGroupFile01" required style="display: <?= $stage_disabled[2] ? 'none' : 'display' ?>">
                    <a href="<?= $data['files']['consent_letter']['name'] ?? "" ?>" class="btn btn-secondary <?= !$stage_disabled[2] ? 'disabled' : '' ?>" role="button" target="_blank">
                      下載 <i class="bi bi-file-earmark-arrow-down"></i>
                    </a>
                  </div>
                </div>
              </div>
              <div class="col-8">
                <div class="my-2">
                  <label for="formGroupExampleInput" class="form-label">核准船期</label>
                  <div class="input-group">
                    <input type="text" name="approved_sailing_date" class="form-control" placeholder="2024-01-01"
                           value="<?= $data['approved_sailing_date'] ?>"  <?= $stage_disabled[2] ? 'disabled' : '' ?> required>
                    <span class="input-group-text" id="basic-addon1">至</span>
                    <input type="text" name="approved_return_date" class="form-control" placeholder="2024-01-01"
                           value="<?= $data['approved_return_date'] ?>" <?= $stage_disabled[2] ? 'disabled' : '' ?> required>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
  <script>
      function submit(e, index) {
          e.preventDefault();
          let form = this;
          let formData = new FormData(form);
          let xhr = new XMLHttpRequest();
          xhr.open('POST', form.action, true);

          xhr.upload.onprogress = function(event) {
              if (event.lengthComputable) {
                  let percentComplete = (event.loaded / event.total) * 100;
                  percentComplete = percentComplete.toFixed();
                  let progressBar = document.getElementById("progressBar" + index)
                  progressBar.style.width = percentComplete + '%';
                  progressBar.innerText = percentComplete + '%';
              }
          };

          xhr.onload = function() {
              window.setTimeout(( () => location.reload() ), 500);
          };

          xhr.send(formData);
      }
      document.getElementById('form2').addEventListener('submit', function(e) { submit.call(this, e, 2); });
      document.getElementById('form3').addEventListener('submit', function(e) { submit.call(this, e, 3); });
      document.getElementById('form4').addEventListener('submit', function(e) { submit.call(this, e, 4); });
  </script>
</body>
