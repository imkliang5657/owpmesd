<?php
$specIndex = 1;
$startPrinting = false;


$orgin_data = "";

foreach ($data as $key => $value) {
    if ($startPrinting && !is_array($value)) {
        $orgin_data .= <<<HTML
<input type="hidden" name="origin_specification_$specIndex" value="$value">
HTML;
        $specIndex++; // 更新索引
    } else if(!is_array($value)) {
        $orgin_data .= <<<HTML
<input type="hidden" name="origin_$key" value="$value">
HTML;
    }
    if ($key === "manufactured_country_flag_image_path") {
        $startPrinting = true;
    }
}
?>
<div class="container ">
        <div class="row">
            <form id="vesselForm" action="./?url=page/create-domestic-ship" method="post">
                <div class="row">
                    <!-- Basic Information -->
                    <div class="col-md-5 ms-5">
                        <div class="header p-2"><strong>基本資訊</strong></div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">船名</label>
                            <div class="col-sm-9 mt-2">
                                <input type="text" class="form-control" id="name" name="name" value="<?=htmlspecialchars($data['name'])?>" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="alias" class="col-sm-3 col-form-label">其他名稱</label>
                            <div class="col-sm-9 mt-2">
                                <input type="text" class="form-control" id="alias" name="alias" value=<?=htmlspecialchars($data['alias'])?>>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="operator" class="col-sm-3 col-form-label">船東</label>
                            <div class="col-sm-9 mt-2">
                                <input type="text" class="form-control" id="operator" name="operator" value=<?=htmlspecialchars($data['operator'])?> required>
                            </div>
                        </div>
                        <div class="input-group mt-2">
                            <label for="description" class="col-sm-3 col-form-label">工作描述</label>
                            <div class="col-sm-9 mt-2">
                                <textarea class="form-control" id="description" name="description" rows="4" ><?=htmlspecialchars($data['description'])?></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="vessel_category_name" class="col-sm-3 col-form-label">船種</label>
                            <div class="col-sm-9 mt-2">
                                <select class="form-control" id="vessel_category_id" name="vessel_category_id" required>
                                <?php echo "<option value=\"" . $data['vessel_category_id'] . "\">" . $data['vessel_category_name'] . "</option>";?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="mmsi" class="col-sm-3 col-form-label">MMSI</label>
                            <div class="col-sm-9 mt-2">
                                <input type="text" class="form-control" id="mmsi" name="mmsi" value=<?=$data['mmsi']?>>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="imo" class="col-sm-3 col-form-label">IMO</label>
                            <div class="col-sm-9 mt-2">
                                <input type="text" class="form-control" id="imo" name="imo" value=<?=$data['imo']?>>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="country" class="col-sm-3 col-form-label">國籍</label>
                            <div class="col-sm-9 mt-2">
                                <select class="form-select" id="country_id" name="country_id" required>
                                    <option value=<?=$data['country_id']?>><?=$data['country_name']?></option>
                                    <?php
                                    foreach ($data as $item) {
                                        if (is_array($item) && isset($item['country_name'])) {
                                            echo "<option value=\"" . $item['country_id'] . "\">" . $item['country_name'] . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="shipyard" class="col-sm-3 col-form-label">建造廠</label>
                            <div class="col-sm-9 mt-2">
                                <input type="text" class="form-control" id="shipyard" name="shipyard" value=<?=htmlspecialchars($data['shipyard'])?>>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="manufactured_country_name" class="col-sm-3 col-form-label">建造國</label>
                            <div class="col-sm-9 mt-2">
                                <select class="form-select" id="manufactured_country_id" name="manufactured_country_id">
                                    <option value=<?=$data['manufactured_country_id']?>><?=$data['manufactured_country_name']?></option>
                                    <?php
                                    foreach ($data as $item) {
                                        if (is_array($item) && isset($item['country_name'])) {
                                            echo "<option value=\"" . $item['country_id'] . "\">" . $item['country_name'] . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="buildDate" class="col-sm-3 col-form-label">建造年份</label>
                            <div class="col-sm-9 mt-2">
                                <input type="text" class="form-control" id="manufactured_at_year" name="manufactured_at_year" value=<?=$data['manufactured_at_year']?>>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="class" class="col-sm-3 col-form-label">船級</label>
                            <div class="col-sm-9 mt-2">
                                <input type="text" class="form-control" id="ship_class" name="ship_class" value=<?=$data['ship_class']?>>
                            </div>
                        </div>
                    </div>

                    <!-- Vessel Basic Specifications -->
                    <div class="col-md-5 ms-5">
                        <div class="header p-2"><strong>船舶基本規格</strong></div>
                        <div class="form-group row">
                            <label for="length" class="col-sm-3 col-form-label">船長(m)</label>
                            <div class="col-sm-9 mt-2">
                                <input type="number" class="form-control" id="length" name="length" step="any" value=<?=$data['length']?> >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="breadth" class="col-sm-3 col-form-label">船寬(m)</label>
                            <div class="col-sm-9 mt-2">
                                <input type="number" class="form-control" id="breadth" name="breadth" step="any" value=<?=$data['breadth']?>>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="depth" class="col-sm-3 col-form-label">船深(m)</label>
                            <div class="col-sm-9 mt-2">
                                <input type="number" class="form-control" id="depth" name="depth" step="any" value=<?=$data['depth']?>>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="maxDraft" class="col-sm-3 col-form-label">最大吃水(m)</label>
                            <div class="col-sm-9 mt-2">
                                <input type="number" class="form-control" id="draft_max" name="draft_max" step="any" value=<?=$data['draft_max']?>>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="minDraft" class="col-sm-3 col-form-label">最小吃水(m)</label>
                            <div class="col-sm-9 mt-2">
                                <input type="number" class="form-control" id="draft_min" name="draft_min" step="any" value=<?=$data['draft_min']?>>
                            </div>
                        </div><div class="form-group row">
                            <label for="maxSpeed" class="col-sm-3 col-form-label">巡航速度</label>
                            <div class="col-sm-9 mt-2">
                                <input type="number" class="form-control" id="transitSpeed" name="transitSpeed" step="any" value=<?=$data['transitSpeed']?>>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="speed_max" class="col-sm-3 col-form-label">最大航速(kt)</label>
                            <div class="col-sm-9 mt-2">
                                <input type="number" class="form-control" id="speed_max" name="speed_max" step="any" value=<?=htmlspecialchars($data['speed_max'])?>>
                            </div>
                        </div>
                        <div class="form-group row">    
                            <label for="freeDeckSpace" class="col-sm-3 col-form-label">甲板空間(m^2)</label>
                            <div class="col-sm-9 mt-2">
                                <input type="number" class="form-control" id="freeDeckSpace" name="freeDeckSpace" step="any" value=<?=$data['freeDeckSpace']?>>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="deck_load_max" class="col-sm-3 col-form-label">甲板承載力(t/m^2)</label>
                            <div class="col-sm-9 mt-2">
                                <input type="number" class="form-control" id="deck_load_max" name="deck_load_max" step="any" value=<?=$data['deck_load_max']?>>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="capacity_weigth" class="col-sm-3 col-form-label">載重量(t)</label>
                            <div class="col-sm-9 mt-2">
                                <input type="number" class="form-control" id="capacity_weigth" name="capacity_weigth" step="any" value=<?=$data['capacity_weigth']?>>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="DPC_class" class="col-sm-3 col-form-label">定位系統</label>
                            <div class="col-sm-9 mt-2">
                                <select class="form-select" id="DPC_class" name="DPC_class" >
                                    <option value=<?=$data['DPC_class']?>><?=$data['DPC_class']?></option>
                                    <option value="1">DP1</option>
                                    <option value="2">DP2</option>
                                    <option value="2">DP3</option>
                                    <option value="3">八點定錨</option>
                                </select>
                            </div>
                        </div>
                    </div>
                                       
                    <!-- 分界線 -->
                    <div class="col-md-12">
                        <hr class="my-4">
                        <?php if(!empty($data['vessel_detail_id']))require APP_ROOT ."views/components/update-detail-information.php";?>
                    </div>
                    <?=$orgin_data?>
            </form>
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