<div class="container my-5">
    <div class="row justify-content-between">
        <div class="col text-center">
            <a href="./?url=page/application-manage" class="btn btn-outline-secondary btn-lg" role="button"><i class="bi bi-box-arrow-left"></i> 管理頁面</a>
        </div>
        <div class="col text-center">
            <a href="./?url=page/application-case&id=<?= $data['applicationId'] ?? '' ?>" class="btn btn-<?= $data['buttons']['style'][0] ?> btn-lg <?= $data['buttons']['disabled'][0] ?>" role="button">風場基本資料</a>
        </div>
        <div class="col text-center">
            <a href="./?url=page/application-requirement&id=<?= $data['applicationId'] ?? '' ?>" class="btn btn-<?= $data['buttons']['style'][1] ?> btn-lg <?= $data['buttons']['disabled'][1] ?>" role="button">需求規格</a>
        </div>
        <div class="col text-center">
            <a href="./?url=page/application-foreign-vessel&id=<?= $data['applicationId'] ?? '' ?>" class="btn btn-<?= $data['buttons']['style'][2] ?> btn-lg <?= $data['buttons']['disabled'][2] ?>" role="button">國外船舶選擇</a>
        </div>
        <div class="col text-center">
            <a href="./?url=page/application-content&id=<?= $data['applicationId'] ?? '' ?>" class="btn btn-<?= $data['buttons']['style'][3] ?> btn-lg <?= $data['buttons']['disabled'][3] ?>" role="button">檢視資料</a>
        </div>
    </div>
</div>