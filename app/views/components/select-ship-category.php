        <div class="row mt-2">
            <div class="col-md-10 ms-5">    
                <div class="form-group row">
                    <div class="col-sm-12 mt-2">
                        <strong>選擇船種</strong>
                        <br>
                        <select class="form-select" id="vessel_category_name" name="vessel_category_name" required>
                            <?php
                                if(!isset($data['vessel_category_name'])){
                                    echo "<option ></option>";
                                    foreach ($data as $item) {
                                    if (is_array($item) && isset($item['vessel_category_name'])) {
                                        echo "<option value=\"" . $item['vessel_category_name'] . "\">" . $item['vessel_category_name'] . "</option>";
                                    }
                                    }
                                }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
        </div> 