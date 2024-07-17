<?php

Class DomesticShipController extends Controller
{
    private mixed $VesselsModel;
    private mixed $VesselDetailsModel;
    private mixed $VesselCategoriesModel;
    private mixed $CountriesModel;
    private mixed $PromiseShippingSchedulesModel;
    private mixed $LogModel;
    private mixed $AvailableShippingSchedulesModel;

    public function __construct() {
        $this->VesselsModel = $this->model('Vessel');
        $this->VesselDetailsModel = $this->model('VesselDetail');
        $this->VesselCategoriesModel = $this->model('VesselCategory');
        $this->CountriesModel = $this->model('Country');
        $this->LogModel = $this->model('Log');
        $this->PromiseShippingSchedulesModel = $this->model('PromiseShippingSchedule');
        $this->AvailableShippingSchedulesModel = $this->model('AvailableShippingSchedule');
    }

    public function addPromiseShipment(){
        $requestData = $this->retrievePostData();
        $vessel_id = $requestData['vessel_id'];
        $start_date = new DateTime($requestData['sailing_date']);
        $end_date = new DateTime($requestData['return_date']);
        $is_detect = false;
        $is_detect = $this->PromiseShippingSchedulesModel->detectShipments($vessel_id, $requestData['sailing_date'], $requestData['return_date']);
        $is_correct_data = ($end_date > $start_date) ? true : false;
        if (!($is_detect) && $is_correct_data) {
            $logTableData = [
              'user_id' => $_SESSION['id'],
              'vessel_id' => $vessel_id,
              'operation' => 'add',
              'change_fields' => "promise_sailing_date promise_return_date"
            ];
            $this->VesselsModel->addVesselDataToTable($logTableData, 'log');
            $this->PromiseShippingSchedulesModel->insertShipment($vessel_id, $requestData['sailing_date'], $requestData['return_date']);
            header("Location: ./?url=domesticShip/domestic-ship&error=success");
        } else {
            // 檢測到重疊的航程
            header("Location: ./?url=domesticShip/domestic-ship&error=shipment");
        }
    }

    public function domesticCategoryShipment(){
        $retrieveGetData = $this->retrieveGetData();
        $vesselsSchedules = [];
        $vessels = $this->VesselsModel->getIdNameByCategory($retrieveGetData['category_name']);
        foreach($vessels as $vessel){
            $availableSchedules = $this->AvailableShippingSchedulesModel->retriveVesselScheduleByVesselId($vessel['id']);
            $promiseSchedules = $this->PromiseShippingSchedulesModel->retriveVesselScheduleByVesselId($vessel['id']);
            $sechedules = array_merge($availableSchedules,$promiseSchedules);
            $vesselsSchedules += [$vessel['name'] => $sechedules];
        }
        $this->view('domestic-shipment',$vesselsSchedules);
    }

    public function addAvailableShipment(){
        $requestData = $this->retrievePostData();
        $vessel_id =$requestData['vessel_id'];
        $start_date = new DateTime($requestData['sailing_date']);
        $end_date = new DateTime($requestData['return_date']);
        $is_detect = false;
        $is_correct_data = ($end_date > $start_date) ? true : false;
        $is_detect = $this-> AvailableShippingSchedulesModel->detectShipments($vessel_id,$requestData['sailing_date'],$requestData['return_date']);
        if(!($is_detect) && $is_correct_data){
            $logTableData = ['user_id'=>$_SESSION['id'],'vessel_id'=>$vessel_id,'operation'=>'add','change_fields'=>"available_sailing_date available_return_date"];
            $this->VesselsModel->addVesselDataToTable($logTableData,'log');
            $this-> AvailableShippingSchedulesModel->insertShipment($vessel_id,$requestData['sailing_date'],$requestData['return_date']);
            header("Location: ./?url=domesticShip/domestic-ship&error=success");
        }
        else{
            header("Location:./?url=domesticShip/domestic-ship&error=shipment");
        }
        print_r($requestData);
    }

    public function updateDomesticShipment(){
        $requestData = $this->retrievePostData();
        $vessel_id =$requestData['vessel_id'];
        $promiseResult = $this->processShipments($requestData, 'promise', $vessel_id, $this->PromiseShippingSchedulesModel);
        $availableResult = ['conflict' => false, 'updated' => false, 'changedFields' => []];

        if (!$promiseResult['conflict']) {
            $availableResult = $this->processShipments($requestData, 'available', $vessel_id, $this->AvailableShippingSchedulesModel);
        }

        $allChangedFields = array_merge($promiseResult['changedFields'], $availableResult['changedFields']);

        if ($promiseResult['conflict'] || $availableResult['conflict']) {
            header("Location:./?url=domesticShip/domestic-ship&error=shipment");
        } elseif ($promiseResult['updated'] || $availableResult['updated']) {
            $changeFieldsStr = implode(' ', $allChangedFields);
            $logTableData = [
              'user_id' => $_SESSION['id'],
              'vessel_id' => $vessel_id,
              'operation' => 'modify',
              'change_fields' => $changeFieldsStr
            ];
            $this->VesselsModel->addVesselDataToTable($logTableData, 'log');
            header("Location: ./?url=domesticShip/domestic-ship&error=success");
        } else {
            header("Location:./?url=domesticShip/domestic-ship-information&ship_id=$vessel_id");
        }
    }

    public function domesticShip() {
        $vesselsByCategory = [];
        $vessels = $this->VesselsModel->retriveAllDomesticVesselsWithCategory();
        $logVessels =$this->LogModel->getIdInTwoWeeks();
        $logVesselsById = [];
        foreach ($logVessels as $logVessel) {
            $logVesselsById[$logVessel['vessel_id']] = $logVessel['operation'];
        }
        foreach ($vessels as $vessel) {
            $vesselData = [
              'id' => $vessel['id'],
              'name' => $vessel['name'],
              'updated_at' => $vessel['updated_at']
            ];
            if (isset($logVesselsById[$vessel['id']])) {
                $vesselData['operation'] = $logVesselsById[$vessel['id']];
            } else {
                $vesselData['operation'] = NULL;
            }
            $vesselsByCategory[$vessel['category']][] = $vesselData;
        }
        $this->view('domestic-ship',$vesselsByCategory);
    }


    public function domesticShipInformation() {
        $retriveData = $this->retrieveGetData();
        $vesselDatas = $retriveData;
        $vesselDatas += $this->VesselsModel->getWholeVesselById($retriveData['ship_id']);
        if(!empty($vesselDatas['vessel_detail_id'])){
            $vesselSpecifications = $this->VesselDetailsModel->retrivedetailById($vesselDatas['vessel_detail_id']);
            $vesselSpecifications = $this->convertSpecifications($vesselDatas['vessel_category_id'],$vesselSpecifications);
            $vesselDatas = array_merge($vesselDatas,$vesselSpecifications);
        }

        $promiseShipment = $this->PromiseShippingSchedulesModel->retriveVesselScheduleByVesselId($retriveData['ship_id']);
        $vesselDatas = array_merge($vesselDatas,$promiseShipment);
        $availableShipment = $this->AvailableShippingSchedulesModel->retriveVesselScheduleByVesselId($retriveData['ship_id']);
        $vesselDatas = array_merge($vesselDatas,$availableShipment);

        //決定進入 顯示畫面or編輯畫面
        if(isset($retriveData['mode'])&&$retriveData['mode']=="update"){
            $countries = $this->CountriesModel->getAllCountries();
            $vesselDatas = array_merge($vesselDatas,$countries);
            $this->view('update-domestic-ship',$vesselDatas);
        }
        else if(isset($retriveData['mode'])&&$retriveData['mode']=="updateShipment"){
            $shipment = array_merge($promiseShipment,$availableShipment);
            $this->view('update-domestic-shipment',$shipment);
        }
        else{
            $this->view('domestic-ship-information',$vesselDatas);
        }


    }


    public function createDomesticShip(){
        $requestData = $this->retrievePostData();
        if(!isset($requestData['vessel_category_id'])){
            $categories = $this->VesselCategoriesModel->getAllVesselCategories();
            $countries = $this->CountriesModel->getAllCountries();
            $data = array_merge($categories,$countries);
            $this->view('create-domestic-ship',$data);
        }
        else{
            $data = $requestData;
            $data += $this->VesselCategoriesModel->getCategoryNameById($requestData['vessel_category_id']);
            $specifications = $this->convertSpecifications($data['vessel_category_id']);
            //當輸入完詳細規格後
            if(count($requestData) > 25){
                $data += ['done' =>1];
            }
            else if(count($specifications) != 0){
                $detail_id = $this->VesselDetailsModel->getNextId();
                $data = array_merge($data,$detail_id);
                $data = array_merge($data,$specifications);
                $this->view('create-domestic-ship',$data);
            }
            else{
                $data += ['vessel_detail_id'=>""];
                $data += ['done' =>1];
            }
        }

        if(isset($data['done'])&& $data['done'] === 1){
            $is_exist_vessel = $this->checkDuplicateVessel($requestData);
            if($is_exist_vessel){
                //新增失敗
                header("Location: ./?url=domesticShip/domestic-ship&error=creat");
            }
            else{
                //requestData切分處理
                //新增部分欄位
                $requestData += ['is_foriegn' => "0",'status' => 'approved'];
                $requestData += $this->VesselsModel->getNextIdByTableName('vessels','vessel');
                //詳細資料
                if(!empty($requestData['vessel_detail_id'])){
                    $detailTableData = $this->validDataforTable($requestData,'vessel_details');
                    $this->VesselsModel->addVesselDataToTable($detailTableData,'vessel_details');
                }
                //處理有關船舶建造的資訊
                if((!empty($requestData['manufactured_country_name']))||(!empty($requestData['shipyard']))||(!empty($requestData['manufactured_at_year']))||(!empty($requestData['ship_class']))){
                    $requestData += $this->VesselsModel->getNextIdByTableName('vessel_manufactured_information','manufactured_information');
                    $manufacturedTableData = $this->validDataforTable($requestData,'vessel_manufactured_information');
                    $this->VesselsModel->addVesselDataToTable($manufacturedTableData,'vessel_manufactured_information');
                }
                //處理船舶通用資料
                $universalTableData = $this->validDataforTable($requestData,'vessels');
                $universalTableData['is_foriegn'] = 0;
                $this->VesselsModel->addVesselDataToTable($universalTableData,'vessels');
                //處理船期資料
                if((!empty($requestData['sailing_date']))&&(!empty($requestData['return_date']))){
                    $shipTimeData = $this->validDataforTable($requestData,'available_shipping_schedules');
                    $this->VesselsModel->addVesselDataToTable($shipTimeData,'available_shipping_schedules');
                }
                //新增log
                $requestData += ['user_id'=>$_SESSION['id'],'operation'=>"add",'change_fields'=>"ALL"];
                $logTableData = $this->validDataforTable($requestData,'log');
                $this->VesselsModel->addVesselDataToTable($logTableData,'log');
                //新增成功導向頁面+GET
                header("Location: ./?url=domesticShip/domestic-ship&error=success");
            }

        }
    }

    public function updateDomesticShip(){
        $requestData = $this->retrievePostData();
        $vessel_id = $requestData['origin_id'];
        $changedFields = [];
        foreach ($requestData as $key => $value) {
            if (strpos($key, 'origin_') === 0) {
                $afterKey = substr($key, 7);
                if (isset($requestData[$afterKey]) && $requestData[$afterKey] != $value) {
                    $changedFields[$afterKey] = $requestData[$afterKey];
                }
            }
        }
        if(!empty($changedFields)){
            if(isset($changedFields['imo'])){
                $is_exist_vessel = $this->VesselsModel->getVesselByIMO($requestData['imo']);
            }
            else if(isset($changedFields['mmsi'])){
                $is_exist_vessel = $this->VesselsModel->getVesselByMMSI($requestData['mmsi']);
            }
            else if(isset($changedFields['name'])){
                $is_exist_vessel = $this->VesselsModel->getVesselByName($requestData['name']);
            }
            if(empty($is_exist_vessel)){
                $detailTableData = $this->validDataforTable($changedFields,'vessel_details');
                $manufacturedTableData = $this->validDataforTable($changedFields,'vessel_manufactured_information');
                $universalTableData = $this->validDataforTable($changedFields,'vessels');
                if(!empty($detailTableData)){
                    if(!empty($requestData['origin_vessel_detail_id'])){
                        $detailTableData += ['id'=>$requestData['origin_vessel_detail_id']];
                        $this->VesselsModel->updateVesselDatatoTable($detailTableData,'vessel_details');
                    }
                }
                if(!empty($manufacturedTableData)){
                    if(!empty($requestData['origin_manufactured_information_id'])){
                        $manufacturedTableData += ['id'=>$requestData['origin_manufactured_information_id']];
                        $this->VesselsModel->updateVesselDatatoTable($manufacturedTableData,'vessel_manufactured_information');
                    }
                    //新增新的表
                    else{
                        $universalTableData += $this->VesselsModel->getNextIdByTableName('vessel_manufactured_information','manufactured_information');
                        $this->VesselsModel->addVesselDataToTable($manufacturedTableData,'vessel_manufactured_information');
                    }
                }
                if(!empty($universalTableData)){
                    if(!empty($vessel_id)){
                        $universalTableData += ['id'=>$vessel_id];
                        $this->VesselsModel->updateVesselDatatoTable($universalTableData,'vessels');
                    }
                }
                foreach($changedFields as $key => $value){
                    $changed .= $key." ";
                }
                $logTableData = ['user_id'=>$_SESSION['id'],'vessel_id'=>$vessel_id,'operation'=>'modify','change_fields'=>$changed];
                $this->VesselsModel->addVesselDataToTable($logTableData,'log');
                header("Location: ./?url=domesticShip/domestic-ship&error=success"); 
            }
            else{
                header("Location:./?url=domesticShip/domestic-ship&error=update");
            }
            
        }
        else{
              header("Location: ./?url=domesticShip/domestic-ship");
        }
    }

    public function shipmentPrint(){
        require_once('./tcpdf/tcpdf.php');
        $retrievePostData = $this->retrievePostData();
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle($retrievePostData['category'].'船期表');
        $pdf->SetSubject($retrievePostData['category'].'船期表');
        $pdf->SetKeywords('TCPDF, PDF, 船期表');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetMargins(15, 15, 15);
        $pdf->SetAutoPageBreak(TRUE, 15);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->SetFont('cid0jp', '', 10);
        $pdf->AddPage();

        // 自定義 CSS 樣式
        $retrievePostData['html'] .= '<style>
        th, td {
            border-bottom: 1px solid #ddd;
        }
        .table-primary {
            background-color: #cfe2ff;
        }</style>';
        $pdf->writeHTML($retrievePostData['html'], true, false, true, false, '');
        $pdf->Output('船期表.pdf', 'I');
        echo htmlentities($retrievePostData['html']);
    }

    public function upload() {
        $postData = $this->retrievePostData();
        $getData = $this->retrieveGetData();
        $maxFileSize = 5 * 1024 * 1024; // 5MB in bytes
        $targetDirectory = "./uploads/vessels_data/" . $getData['id'];
    
        if (!is_dir($targetDirectory)) {
            mkdir($targetDirectory, 0777, true);
        }
    
        $uniqueIdentifier = time(); // Using time as a unique identifier
    
        // Image upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
            $fileType = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $allowedFileTypes = ['jpg', 'jpeg', 'png'];
            if (in_array($fileType, $allowedFileTypes) && ($_FILES['image']['size'] <= $maxFileSize)) {
                $targetFilePath = $targetDirectory . "/船圖_" . $uniqueIdentifier . "." . $fileType;
                $targetPaths['image'] = $targetFilePath;
                move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath);
            }
        }
    
        // Specification upload
        if (isset($_FILES['specification']) && $_FILES['specification']['error'] == UPLOAD_ERR_OK) {
            $fileType = pathinfo($_FILES['specification']['name'], PATHINFO_EXTENSION);
            $allowedFileTypes = ['pdf'];
            if (in_array($fileType, $allowedFileTypes) && ($_FILES['specification']['size'] <= $maxFileSize)) {
                $targetFilePath = $targetDirectory . "/規格書_" . $uniqueIdentifier . "." . $fileType;
                $targetPaths['specification'] = $targetFilePath;
                move_uploaded_file($_FILES['specification']['tmp_name'], $targetFilePath);
            }
        }
    
        if (!empty($targetPaths)) {
            $targetPaths['id'] = $getData['id'];
            $this->VesselsModel->updateVesselDatatoTable($targetPaths, "vessels");
            header("Location: ./?url=domesticShip/domestic-ship&error=success");
        } else {
            header("Location: ./?url=domesticShip/domestic-ship&error=upload");
        }
    }
    

    public function download(){
        $getData = $this->retrieveGetData();
        $specificationPath = $this->VesselsModel->retriveSpeciticationPathById($getData['id']);
        if (file_exists($specificationPath['specification'])) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="'.$getData['name']."規格書.".pathinfo($specificationPath['specification'], PATHINFO_EXTENSION));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($specificationPath['specification']));
            readfile($specificationPath['specification']);
            exit;
        } 
        header("Location: ./?url=domesticShip/domestic-ship-information&ship_id={$getData['id']}");
    }

    private function processShipments($requestData, $type, $vesselId, $model) {
        $shipments = [];
        $idKey = $type . '_shipping_schedules_id';
        $sailingDateKey = $type . '_sailing_date';
        $returnDateKey = $type . '_return_date';
        $originSailingDateKey = 'origin_' . $type . '_sailing_date';
        $originReturnDateKey = 'origin_' . $type . '_return_date';
        $changedFields = [];

        foreach ($requestData[$idKey] as $key => $id) {
            if ($requestData[$originSailingDateKey][$key] != $requestData[$sailingDateKey][$key]) {
                $changedFields[] = $sailingDateKey;
            }
            if ($requestData[$originReturnDateKey][$key] != $requestData[$returnDateKey][$key]) {
                $changedFields[] = $returnDateKey;
            }
            if (!empty($changedFields)) {
                $shipments[] = [
                  'id' => $id,
                  'sailing_date' => $requestData[$sailingDateKey][$key],
                  'return_date' => $requestData[$returnDateKey][$key]
                ];
            }
        }

        $is_detect = false;
        foreach($shipments as $shipment){
            $is_detect = $model->detectShipments($vesselId, $shipment['sailing_date'], $shipment['return_date'], $shipment['id']);
            if($is_detect) {
                return ['conflict' => true, 'updated' => false, 'changedFields' => []];
            }
        }

        if(!$is_detect && !empty($shipments)){
            foreach ($shipments as $shipment) {
                $this->VesselsModel->updateVesselDatatoTable($shipment, $type . '_shipping_schedules');
            }
            return ['conflict' => false, 'updated' => true, 'changedFields' => array_unique($changedFields)];
        }

        return ['conflict' => false, 'updated' => false, 'changedFields' => []];
    }

    //convertEnglishToChineseForSpecificationColumns
    public function convertSpecifications($category,$vesselSpecifications=[]){
        $categoryMappings = [
          1 => [
            'specification_1'=>'最大吊重(t)',
            'specification_2'=>'最大吊高(m)',
            'specification_3'=> '最大吊重半徑(m)',
            'specification_4'=>'作業水深(m)',
            'specification_5'=> '其他設備(備註)',
          ],
          2 => [
            'specification_1'=>'支撐腳長(m)',
            'specification_2'=>'最大吊重(t)',
            'specification_3'=>'最大吊高(m)',
            'specification_4'=> '最大吊重半徑(m)',
            'specification_5'=> '作業水深(m)',
            'specification_6'=> '其他設備(備註)',
          ],
          3 => [
            'specification_1'=>'盤纜槽裝載量(t)',
            'specification_2'=> '作業水深(m)',
            'specification_3'=> '其他設備(備註)',
          ],
          4 => [
            'specification_1'=>'裝載量能(t)',
            'specification_2'=>'工作速度(t/hr)',
            'specification_3'=> '作業深度(m)',
            'specification_4'=> '其他設備(備註)',
          ],
          5 => [
            'specification_1'=>'裝載量能(t)',
            'specification_2'=> '工作速度(t/hr)',
            'specification_3'=> '作業深度(m)',
            'specification_4'=> '其他設備(備註)',
          ],
          6 => [
            'specification_1'=>'繫纜拖力(t)',
            'specification_2'=> '其他設備(備註)',
          ],
          7 => [
            'specification_1'=>'繫纜拖力(t)',
            'specification_2'=> '其他設備(備註)',
          ],
          8 => [
            'specification_1'=>'其他設備(備註)',
          ],
          9 => [
            'specification_1'=>'動態補償舷梯',
            'specification_2'=> '床位數(POB)',
            'specification_3'=> '其他設備(備註)',
          ],
          14 => [
            'specification_1'=>'床位數(POB)',
            'specification_2'=> '其他設備(備註)',
          ],
          15 => [
            'specification_1' => '床位數(POB)',
            'specification_2' => '其他設備(備註)',
          ],
        ];
        $specifications = [];
        if (isset($categoryMappings[$category])) {
            $mappings = $categoryMappings[$category];
            foreach ($mappings as $key => $label) {
                if(isset($vesselSpecifications[$key])){
                    $specifications[$label] = $vesselSpecifications[$key];
                }
                else{
                    $specifications[$label] = "";
                }
            }
        }
        return $specifications;
    }



    private function checkDuplicateVessel(array $data):bool
    {
        if (!empty($data['imo']) ) {
            $existingVessel = $this->VesselsModel->getVesselByIMO($data['imo']);
            if ($existingVessel) {
                return true;
            }
        }
        else if (!empty($data['mmsi'])) {
            $existingVessel = $this->VesselsModel->getVesselByMMSI($data['mmsi']);
            if ($existingVessel) {
                return true;
            }
        }
        else if (!empty($data['name'])) {
            $existingVessel = $this->VesselsModel->getVesselByName($data['name']);
            if ($existingVessel) {
                return true;
            }
        }
        return false;
    }

    //對應資料表欄位進行切割
    private function validDataforTable(array &$data,$table_name):array
    {
        $column_names = $this->VesselsModel->getColumnsName($table_name);
        $validData = [];

        foreach ($column_names as $column_name) {
            foreach ($column_name as $item) {
                if (isset($data[$item])) {
                    $validData[$item] = empty($data[$item]) ? NULL : $data[$item];

                }
            }
        }
        return $validData;
    }
}