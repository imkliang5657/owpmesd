<div class="col-sm-5 mb-4 mb-sm-4">
    <div class="card p-2">
        <div class="card-body">
            <form method="post" action="./?url=upsert-wind-farm-information">
                <input type="hidden" name="id" value="<?= $id??null ?>">
                <input type="hidden" name="wind_farm_id" value="<?= $data['windFarm']['id'] ?>">
                <div class="row">
                    <div class="col-5">
                        <h4 class="card-title mb-3">基本資料</h4>
                    </div>
                </div>
                <div class="input-group my-3">
                    <span class="input-group-text">船種</span>
                    <select class="form-select" name="vessel_category_id" aria-label="vessel_category" required <?= $_SESSION['identity'] == 'domestic_maritime_association' ? 'disabled' : ''; ?>>
                        <option selected disabled></option>
                        <?php foreach ($data['vesselCategories'] as $vesselCategory): ?>
                            <option value="<?= $vesselCategory['id'] ?>" <?= ($info['vessel_category_id']??null == $vesselCategory['id']) ? 'selected' : '' ?>><?= $vesselCategory['vessel_category_name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">工作項目</span>
                    <input type="text" class="form-control" name="item" aria-label="item" value="<?= $info['item']??null ?>" required <?= $_SESSION['identity'] == 'domestic_maritime_association' ? 'disabled' : ''; ?>>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">使用船期</span>
                    <input type="text" class="form-control datepicker" name="start_shipment_time" aria-label="start_shipment_time" value="<?= $info['start_shipment_time']??null ?>" required <?= $_SESSION['identity'] == 'domestic_maritime_association' ? 'disabled' : ''; ?>>
                    <span class="input-group-text">至</span>
                    <input type="text" class="form-control datepicker" name="end_shipment_time" aria-label="end_shipment_time" value="<?= $info['end_shipment_time']??null ?>" required <?= $_SESSION['identity'] == 'domestic_maritime_association' ? 'disabled' : ''; ?>>
                </div>
                <div class="input-group mb-3">
                <span class="input-group-text">完工日期</span>
                    <input type="text" class="form-control datepicker" name="start_shipment_time" aria-label="start_shipment_time" value="<?= null ?>" >
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">需求規格</span>
                    <textarea class="form-control" name="detail" rows="10" aria-label="detail" required <?= $_SESSION['identity'] == 'domestic_maritime_association' ? 'disabled' : ''; ?>><?= $info['detail']??null ?></textarea>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">數量</span>
                    <input type="number" class="form-control" name="number" aria-label="number" value="<?= $info['number']??null ?>" required <?= $_SESSION['identity'] == 'domestic_maritime_association' ? 'disabled' : ''; ?>>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="is_signed-<?= $id??null ?>" name="is_signed" value="1" <?= $info['is_signed']??null ? 'checked' : '' ?> <?= $_SESSION['identity'] == 'domestic_maritime_association' ? 'disabled' : ''; ?>>
                    <label class="form-check-label" for="is_signed-<?= $id??null ?>">已簽約</label>
                </div>
                <div class="btn-group" role="group" aria-label="submit">
                    <?php if (empty($id)): ?>
                        <button type="submit" class="btn btn-primary" <?= $_SESSION['identity'] == 'domestic_maritime_association' ? 'disabled' : ''; ?>><i class="bi bi-plus-lg"></i> 新增</button>
                    <?php else: ?>
                        <button type="submit" class="btn btn-primary" <?= $_SESSION['identity'] == 'domestic_maritime_association' ? 'disabled' : ''; ?>><i class="bi bi-floppy"></i> 儲存</button>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
</div>