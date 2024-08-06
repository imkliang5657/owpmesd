<div class="container ">
    <div class="row">
        <div class="row">
            <!-- Basic Information -->
            <div class="col-md-5 ms-5">
                <?php $vessel = $data['application_vessel']; ?>
                <input type="hidden" name="application_id" value="<?= $data['applicationId'] ?>">
                <div class="header p-2"><strong>基本資訊</strong></div>
                <div class="form-group row">
                    <label for="name" class="col-sm-3 col-form-label">船名</label>
                    <div class="col-sm-9 mt-2">
                        <input type="text" class="form-control" id="name" name="name" value="<?= $vessel['name'] ?? null ?>" required>
                    </div>
                    <!-- <h1><?= var_dump($vessel) ?></h1> -->
                </div>
                <div class="form-group row">
                    <label for="alias" class="col-sm-3 col-form-label">其他名稱</label>
                    <div class="col-sm-9 mt-2">
                        <input type="text" class="form-control" id="alias" name="alias" value="<?= $vessel['alias'] ?? null ?>">
                    </div>
                </div>
                <div class="input-group mt-2">
                    <label for="description" class="col-sm-3 col-form-label">工作描述</label>
                    <div class="col-sm-9 mt-2">
                        <textarea class="form-control" id="description" name="description" rows="4"><?= $vessel['description'] ?? null ?></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="operator" class="col-sm-3 col-form-label">船東</label>
                    <div class="col-sm-9 mt-2">
                        <input type="text" class="form-control" id="operator" name="operator" value="<?= $vessel['operator'] ?? null ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="vessel_category_name" class="col-sm-3 col-form-label">船種</label>
                    <div class="col-sm-5 mt-2">
                        <div class="header p-2"><?= $data['vesselCategoryName']["vessel_category_name"] ?></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="IMO" class="col-sm-3 col-form-label">IMO</label>
                    <div class="col-sm-9 mt-2">
                        <input type="text" class="form-control" id="imo" name="imo" value="<?= $vessel['imo'] ?? null ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="MMSI" class="col-sm-3 col-form-label">MMSI</label>
                    <div class="col-sm-9 mt-2">
                        <input type="text" class="form-control" id="mmsi" name="mmsi" value="<?= $vessel['mmsi'] ?? null ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="country_id" class="col-sm-3 col-form-label">國籍</label>
                    <div class="col-sm-9 mt-2">
                        <select class="form-select" id="country_id" name="country_id" required>
                            <option selected disabled></option>
                            <?php foreach ($data['countries'] as $countries) : ?>
                                <option value="<?= $countries['country_id'] ?>" <?= ($vessel['country_id'] ?? null )== $countries['country_id'] ? 'selected' : '' ?>><?= $countries['country_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="shipyard" class="col-sm-3 col-form-label">建造廠</label>
                    <div class="col-sm-9 mt-2">
                        <input type="text" class="form-control" id="shipyard" name="shipyard" value="<?= $vessel['shipyard'] ?? null ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="manufactured_country_name" class="col-sm-3 col-form-label">建造國</label>
                    <div class="col-sm-9 mt-2">
                        <select class="form-select" id="manufactured_country_id" name="manufactured_country_id">
                            <option selected disabled></option>
                            <?php foreach ($data['countries'] as $countries) : ?>
                                <option value="<?= $countries['country_id'] ?>" <?= ($vessel['manufactured_country_id'] ?? null) == $countries['country_id'] ? 'selected' : '' ?>><?= $countries['country_name'] ?></option>
                            <?php endforeach; ?>
                        </select>


                    </div>
                </div>
                <div class="form-group row">
                    <label for="buildDate" class="col-sm-3 col-form-label">建造年份</label>
                    <div class="col-sm-9 mt-2">
                        <input type="text" class="form-control" id="manufactured_at_year" name="manufactured_at_year" value="<?= $vessel['manufactured_at_year'] ?? null ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="class" class="col-sm-3 col-form-label">船級</label>
                    <div class="col-sm-9 mt-2">
                        <input type="text" class="form-control" id="ship_class" name="ship_class"value="<?= $vessel['ship_class'] ?? null ?>">
                    </div>
                </div>
            </div>

            <!-- Vessel Basic Specifications -->
            <div class="col-md-5 ms-5">
                <div class="header p-2"><strong>船舶基本規格</strong></div>
                <div class="form-group row">
                    <label for="length" class="col-sm-3 col-form-label">船長(m)</label>
                    <div class="col-sm-9 mt-2">
                        <input type="number" class="form-control" id="length" name="length" value="<?= $vessel['length'] ?? null ?>" step="any">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="breadth" class="col-sm-3 col-form-label">船寬(m)</label>
                    <div class="col-sm-9 mt-2">
                        <input type="number" class="form-control" id="breadth" name="breadth" value="<?= $vessel['breadth'] ?? null ?>"step="any">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="depth" class="col-sm-3 col-form-label">船深(m)</label>
                    <div class="col-sm-9 mt-2">
                        <input type="number" class="form-control" id="depth" name="depth" value="<?= $vessel['depth'] ?? null ?>" step="any">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="maxDraft" class="col-sm-3 col-form-label">最大吃水(m)</label>
                    <div class="col-sm-9 mt-2">
                        <input type="number" class="form-control" id="draft_max" name="draft_max" value="<?= $vessel['draft_max'] ?? null ?>" step="any">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="minDraft" class="col-sm-3 col-form-label">最小吃水(m)</label>
                    <div class="col-sm-9 mt-2">
                        <input type="number" class="form-control" id="draft_min" name="draft_min" value="<?= $vessel['draft_min'] ?? null ?>" step="any">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="maxSpeed" class="col-sm-3 col-form-label">巡航速度</label>
                    <div class="col-sm-9 mt-2">
                        <input type="number" class="form-control" id="transitSpeed" name="transitSpeed" value="<?= $vessel['transitSpeed'] ?? null ?>" step="any">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="speed_max" class="col-sm-3 col-form-label">最大航速(節)</label>
                    <div class="col-sm-9 mt-2">
                        <input type="number" class="form-control" id="speed_max" name="speed_max" value="<?= $vessel['speed_max'] ?? null ?>" step="any">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="freeDeckSpace" class="col-sm-3 col-form-label">甲板空間(m^2)</label>
                    <div class="col-sm-9 mt-2">
                        <input type="number" class="form-control" id="freeDeckSpace" name="freeDeckSpace" value="<?= $vessel['freeDeckSpace'] ?? null ?>" step="any">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="deck_load_max" class="col-sm-3 col-form-label">甲板承載力(t/m^2)</label>
                    <div class="col-sm-9 mt-2">
                        <input type="number" class="form-control" id="deck_load_max" name="deck_load_max" value="<?= $vessel['deck_load_max'] ?? null ?>" step="any">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="capacity_weigth" class="col-sm-3 col-form-label">載重量(t)</label>
                    <div class="col-sm-9 mt-2">
                        <input type="number" class="form-control" id="capacity_weigth" name="capacity_weigth" value="<?= $vessel['capacity_weigth'] ?? null ?>" step="any">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="DPC_class" class="col-sm-3 col-form-label">定位系統</label>
                    <div class="col-sm-9 mt-2">
                        <select class="form-select" id="DPC_class" name="DPC_class">
                            <option value=""></option>
                            <option value="1" <?=($vessel['DPC_class']??null)==1 ? 'selected':''?>>DP1</option>
                            <option value="2"<?=($vessel['DPC_class']??null)==2 ? 'selected':''?>>DP2</option>
                            <option value="3"<?=($vessel['DPC_class']??null)==3 ? 'selected':''?>>DP3</option>
                            <option value="4"<?=($vessel['DPC_class']??null)==4 ? 'selected':''?>>八點定錨</option>

                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="header p-2"><strong>特殊規格</strong></div>
                <?php foreach ($data['columns'] as $index => $column) : ?>
                    <div class="input-group my-3">
                      <label for="capacity_weigth" class="col-sm-3 col-form-label"><?= $column ?></label>
                        <div class="col-sm-5 mt-2">
                            <input type="text" class="form-control" name="specification_<?= $index + 1 ?>" value="<?= $vessel['specification_' . $index + 1] ?? null ?>">
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#country_id').select2({
            placeholder: '',
            allowClear: true
        });

        $('#manufactured_country_id').select2({
            placeholder: '',
            allowClear: true
        });
    });
</script>