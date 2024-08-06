<?php require APP_ROOT . 'views/include/header.php'; ?>
<style>
    .th-property {
        width: 25%;
    }
</style>

<body>
    <?php require APP_ROOT . 'views/components/userNavBar.php'; ?>
    <div class="container-sm my-5">
        <?php require APP_ROOT . 'views/components/application-stage.php'; ?>
        <div class="row m-5">
            <div class="card p-2">
                <div class="card-body">
                    <input type="hidden" name="application_id" value="<?= $data['applicationId'] ?>">
                    <table class="table table-striped table-hover">
                        <tr>
                            <th colspan="2" class="table-primary"> 風場基本資料</th>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <table class="table mb-0">
                                    <tr>
                                        <th class="th-property">風場</th>
                                        <td><?= $data['application']['wind_farm_name'] ?></td>
                                    </tr>
                                    <tr>
                                        <th class="th-property">工作項目</th>
                                        <td><?= $data['application']['work_item'] ?></td>
                                    </tr>
                                    <tr>
                                        <th class="th-property">船種</th>
                                        <td><?= $data['application']['vessel_category_name'] ?></td>
                                    </tr>
                                    <tr>
                                        <th class="th-property">船期</th>
                                        <td><?= $data['application']['required_sailing_date'] ?> ~ <?= $data['application']['required_return_date'] ?></td>
                                    </tr>
                                    <tr>
                                        <th class="th-property">描述</th>
                                        <td><?= $data['application']['description'] ?></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <th colspan="2" class="table-primary">需求規格</th>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <table class="table mb-0">
                                    <?php foreach ($data['columns'] as $index => $column) : ?>
                                        <tr>
                                            <th class="th-property"><?= $column ?></th>
                                            <td><?= $data['application']['specification_' . $index + 1] ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <table class="table mb-0">
                                    <!-- <tr>
                                    <th class="th-property">船名</th>
                                    <h1><?= var_dump($data['vessel']) ?></h1>
                                    <td><?php $vessel = $data['vessel'] ?></td>
                                </tr> -->

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
                                                        <div class="col-sm-9"><?= $vessel['name'] ?></div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-sm-3"><strong>其他名稱</strong></div>
                                                        <div class="col-sm-9"><?= $vessel['alias'] ?></div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-sm-3"><strong>船東</strong></div>
                                                        <div class="col-sm-9"><?= $vessel['operator'] ?></div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-sm-3"><strong>船種</strong></div>
                                                        <div class="col-sm-9"><?= $vessel['vessel_category_name'] ?></div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-sm-3"><strong>描述</strong></div>
                                                        <div class="col-sm-9"><?= $vessel['description'] ?></div>
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
                                                        <div class="col-sm-6"><?= $vessel['length'] ?></div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-sm-6"><strong>船寬(m)</strong></div>
                                                        <div class="col-sm-6"><?= $vessel['breadth'] ?></div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-sm-6"><strong>船深(m)</strong></div>
                                                        <div class="col-sm-6"><?= $vessel['depth'] ?></div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-sm-6"><strong>最小設計吃水(m)</strong></div>
                                                        <div class="col-sm-6"><?= $vessel['draft_min'] ?></div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-sm-6"><strong>最大設計吃水(m)</strong></div>
                                                        <div class="col-sm-6"><?= $vessel['draft_max'] ?></div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-sm-6"><strong>巡航速度(kt)</strong></div>
                                                        <div class="col-sm-6"><?= $vessel['transitSpeed'] ?></div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-sm-6"><strong>最大速度(kt)</strong></div>
                                                        <div class="col-sm-6"><?= $vessel['speed_max'] ?></div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-sm-6"><strong>空閒甲板面積(m^2)</strong></div>
                                                        <div class="col-sm-6"><?= $vessel['freeDeckSpace'] ?></div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-sm-6"><strong>甲板承載力(t/m^2)</strong></div>
                                                        <div class="col-sm-6"><?= $vessel['deck_load_max'] ?></div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-sm-6"><strong>載重量(t)</strong></div>
                                                        <div class="col-sm-6"><?= $vessel['capacity_weigth'] ?></div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-sm-6"><strong>動態定位(DPCClass)</strong></div>
                                                        <div class="col-sm-6"><?= $vessel['DPC_class'] ?></div>
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
                                                        <div class="col-sm-9"><?= $vessel['mmsi'] ?></div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-sm-3"><strong>IMO</strong></div>
                                                        <div class="col-sm-9"><?= $vessel['imo'] ?></div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-sm-3"><strong>國籍</strong></div>
                                                        <div class="col-sm-9"><?= $vessel['country_name'] ?></div>
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
                                                                <div class="col-sm-9"><?= $vessel['shipyard'] ?></div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-sm-3"><strong>造船國</strong></div>
                                                                <div class="col-sm-9"><?= $vessel['manufactured_country_name'] ?></div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-sm-3"><strong>建造日期</strong></div>
                                                                <div class="col-sm-9"><?= $vessel['manufactured_at_year'] ?></div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-sm-3"><strong>船級</strong></div>
                                                                <div class="col-sm-9"><?= $vessel['ship_class'] ?></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-md-12">
                                                <div class="card">
                                                    <div class="card-header">
                                                        特殊規格
                                                    </div>
                                                    <div class="card-body">
                                                        <?php foreach ($data['columns'] as $index => $column) : ?>
                                                            <div class="row mb-2">
                                                                <div class="col-sm-3"><strong><?= $column ?></strong></div>
                                                                <div class="col-sm-9"><?= $vessel['specification_' . $index + 1]  ?>
                                                                </div>
                                                            <?php endforeach; ?>
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <div class="col-md-12">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            上傳檔案
                                                        </div>
                                                        <div class="card-body">
                                                        <div class="row mb-2">
                                                            <div class="col-sm-3"><strong>船籍證書</strong></div>
                                                            <div class="col-sm-9"><a href="<?= $data['file'][0]['name'] ?>" download>船籍證書</a></div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-sm-3"><strong>船舶規格</strong></div>
                                                            <div class="col-sm-9"><a href="<?= $data['file'][1]['name'] ?>" download>船舶規格</a></div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-sm-3"><strong>其他資料</strong></div>
                                                            <div class="col-sm-9"><a href="<?= $data['file'][0]['type']=='reference' ? $data['file'][0]['name']:null ?>"><?= $data['file'][0]['type']=='reference' ?'其他資料':''  ?></a></div>
                                                        </div>
                            </td>
                        </tr>
                    </table>
                    <?php if ($data['edited']) : ?>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                            確認送出
                        </button>
                    <?php endif; ?>

                    <!-- Modal -->
                    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title text-danger" id="staticBackdropLabel"><i class="bi bi-exclamation-triangle-fill"></i> 警告</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p class="text-danger">送出後不可進行修改，是否確認送出？</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                                    <a href="./?url=submit-application-content&id=<?= $data['applicationId'] ?>" class="btn btn-primary" role="button">提交審查</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require APP_ROOT . 'views/include/footer.php'; ?>
</body>