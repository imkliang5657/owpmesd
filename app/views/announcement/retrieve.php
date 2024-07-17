<?php
  $fileLinks = NULL;
  if(!empty($data['files'])) {
    foreach ($data['files'] as $file)
    $fileLinks .= <<<HTML
      <a href="./file/{$file['name']}" download="./file/{$file['name']}" class="btn btn-sm btn-outline-secondary" tabindex="-1" role="button">
        <i class="bi bi-file-earmark-text-fill"></i> {$file['name']}
      </a>
    HTML;
  }
?>
<?php require APP_ROOT . 'views/include/header.php';?>
<body>
<?php require APP_ROOT . 'views/components/userNavBar.php';?>
<div class="container my-5">
    <div class="row mt-2">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-9 py-1 px-4">
                            <h5 class="my-2"><i class="bi bi-info-circle-fill"></i> <?= $data['announcement']['title'] ?></h5>
                        </div>
                    </div>
                </div>
                <div class="card-body p-5">
                    <p><?= $data['announcement']['content'] ?></p>
                    <?= $fileLinks ?>
                </div>
                <div class="card-footer mt-2">
                    由<?= $data['announcement']['organization']?> 於 <?= $data['announcement']['updated_at']?> 發布
                </div>
            </div>
        </div>
    </div>
    <script src="./js/datepicker.js"></script>
</body>
