<?php require APP_ROOT . 'views/include/header.php'; ?>

<body>
    <?php require APP_ROOT . 'views/components/userNavBar.php'; ?>
    <div class="container my-5">
        <div class="card">
            <div class="card-header">
                <a href="./?url=page/application-case" class="btn btn-primary" role="button"><i class="bi bi-plus-lg"></i> 新增申請案</a>
            </div>
            <div class="card-body">

                <table class="table  table-hover ">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>船名</th>
                            <th>填表階段</th>
                            <th>操作</th>
                            <th> 下載</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($data['applications'] as $application) : ?>
                            <tr>
                                <td><?= $i ?></td>
                                <td> <?= $application['vesselname'] ?> </td>
                                <td><?= $application['statusText'] ?></td>
                                <td>
                                    <a href="./?url=application-stage&id=<?= $application['id'] ?>" class="btn btn-primary">
                                        <i class="bi bi-<?= $application['status'] == 'edited' ? 'pencil-square' : 'eye-fill' ?>"></i>
                                        <?= $application['status'] == 'edited' ? '編輯' : '檢視' ?>
                                    </a>
                                </td>
                                <?php if ($application['download'] != null) : ?>
                                    <td><a href="<?= $application['download'] ?>" class="btn btn-primary"><i class="bi bi-box-arrow-down"></i>
                                            <?= $application['statustype'] == 'conference_notice' ? '下載開會通知單' : '下載會議紀錄' ?>
                                        </a></td>
                                <?php else:?>
                                    <td></td>
                                <?php endif; ?>
                            </tr>
                            <?php $i++; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php require APP_ROOT . 'views/include/footer.php'; ?>
</body>