<div class="container ">
        <div class="row">
                <div class="row">
                    <!-- Basic Information -->
                    <div class="col-md-5 ms-5">
                        <div class="header p-2"><strong>基本資訊</strong></div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">船名</label>
                            <div class="col-sm-9 mt-2">
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="alias" class="col-sm-3 col-form-label">其他名稱</label>
                            <div class="col-sm-9 mt-2">
                                <input type="text" class="form-control" id="alias" name="alias" >
                            </div>
                        </div>
                        <div class="input-group mt-2">
                            <label for="description" class="col-sm-3 col-form-label">工作描述</label>
                            <div class="col-sm-9 mt-2">
                                <textarea class="form-control" id="description" name="description" rows="4" ></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="operator" class="col-sm-3 col-form-label">船東</label>
                            <div class="col-sm-9 mt-2">
                                <input type="text" class="form-control" id="operator" name="operator" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="vessel_category_name" class="col-sm-3 col-form-label">船種</label>
                            <div class="col-sm-9 mt-2">
                                <select class="form-select" id="vessel_category_id" name="vessel_category_id" required>
                                <option value=""></option>
                                <?php
                                    foreach ($data as $item) {
                                        if (is_array($item) && isset($item['vessel_category_name'])) {
                                            echo "<option value=\"" . $item['vessel_category_id'] . "\">" . $item['vessel_category_name'] . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="IMO" class="col-sm-3 col-form-label">IMO</label>
                            <div class="col-sm-9 mt-2">
                                <input type="text" class="form-control" id="imo" name="imo">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="MMSI" class="col-sm-3 col-form-label">MMSI</label>
                            <div class="col-sm-9 mt-2">
                                <input type="text" class="form-control" id="mmsi" name="mmsi">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="country_id" class="col-sm-3 col-form-label">國籍</label>
                            <div class="col-sm-9 mt-2">
                                <select class="form-select" id="country_id" name="country_id" required>
                                    <option value=""></option>
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
                                <input type="text" class="form-control" id="shipyard" name="shipyard">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="manufactured_country_name" class="col-sm-3 col-form-label">建造國</label>
                            <div class="col-sm-9 mt-2">
                                <select class="form-select" id="manufactured_country_id" name="manufactured_country_id">
                                    <option value=""></option>
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
                                <input type="text" class="form-control" id="manufactured_at_year" name="manufactured_at_year">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="class" class="col-sm-3 col-form-label">船級</label>
                            <div class="col-sm-9 mt-2">
                                <input type="text" class="form-control" id="ship_class" name="ship_class">
                            </div>
                        </div>
                    </div>

                    <!-- Vessel Basic Specifications -->
                    <div class="col-md-5 ms-5">
                        <div class="header p-2"><strong>船舶基本規格</strong></div>
                        <div class="form-group row">
                            <label for="length" class="col-sm-3 col-form-label">船長(m)</label>
                            <div class="col-sm-9 mt-2">
                                <input type="number" class="form-control" id="length" name="length" step="any">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="breadth" class="col-sm-3 col-form-label">船寬(m)</label>
                            <div class="col-sm-9 mt-2">
                                <input type="number" class="form-control" id="breadth" name="breadth" step="any">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="depth" class="col-sm-3 col-form-label">船深(m)</label>
                            <div class="col-sm-9 mt-2">
                                <input type="number" class="form-control" id="depth" name="depth" step="any">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="maxDraft" class="col-sm-3 col-form-label">最大吃水(m)</label>
                            <div class="col-sm-9 mt-2">
                                <input type="number" class="form-control" id="draft_max" name="draft_max" step="any">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="minDraft" class="col-sm-3 col-form-label">最小吃水(m)</label>
                            <div class="col-sm-9 mt-2">
                                <input type="number" class="form-control" id="draft_min" name="draft_min" step="any">
                            </div>
                        </div><div class="form-group row">
                            <label for="maxSpeed" class="col-sm-3 col-form-label">巡航速度</label>
                            <div class="col-sm-9 mt-2">
                                <input type="number" class="form-control" id="transitSpeed" name="transitSpeed" step="any">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="speed_max" class="col-sm-3 col-form-label">最大航速(節)</label>
                            <div class="col-sm-9 mt-2">
                                <input type="number" class="form-control" id="speed_max" name="speed_max" step="any">
                            </div>
                        </div>
                        <div class="form-group row">    
                            <label for="freeDeckSpace" class="col-sm-3 col-form-label">甲板空間(m^2)</label>
                            <div class="col-sm-9 mt-2">
                                <input type="number" class="form-control" id="freeDeckSpace" name="freeDeckSpace" step="any">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="deck_load_max" class="col-sm-3 col-form-label">甲板承載力(t/m^2)</label>
                            <div class="col-sm-9 mt-2">
                                <input type="number" class="form-control" id="deck_load_max" name="deck_load_max" step="any">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="capacity_weigth" class="col-sm-3 col-form-label">載重量(t)</label>
                            <div class="col-sm-9 mt-2">
                                <input type="number" class="form-control" id="capacity_weigth" name="capacity_weigth" step="any">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="DPC_class" class="col-sm-3 col-form-label">定位系統</label>
                            <div class="col-sm-9 mt-2">
                                <select class="form-select" id="DPC_class" name="DPC_class">
                                    <option value=""></option>
                                    <option value="1">DP1</option>
                                    <option value="2">DP2</option>
                                    <option value="2">DP3</option>
                                    <option value="3">八點定錨</option>
                                    
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- 分界線 -->
                    <div class="col-md-11 ms-5">
                        <hr class="my-4">
                        <div class="form-group row">
                            <label for="availableDateFrom" class="col-sm-3 col-form-label">開始船期</label>
                            <div class="col-sm-6 mt-2">
                                <input type="date" class="form-control" id="sailing_date" name="sailing_date">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="availableDateTo" class="col-sm-3 col-form-label">結束船期</label>
                            <div class="col-sm-6 mt-2">
                                <input type="date" class="form-control" id="return_date" name="return_date">
                            </div>
                        </div>
                    </div>
                </div>
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