<?php

class ApplicationController extends Controller
{
    private mixed $applicationModel;
    private mixed $applicationFileModel;
    private mixed $vesselModel;
    private mixed $CountriesModel;
    private mixed $vesselDetailModel;
    private mixed $windFarmModel;
    private mixed $vesselCategoryModel;
    private mixed $applicationInformationModel;
    private mixed $applicationForeignVesselModel;
    private mixed $applicationVesselRequirementModel;


    private function convertStatusFromEnglishToChinese($status): string
    {
        $rule = [
            'edited' => '編輯中',
            'submitted' => '尚未審查',
            'prepare_conference' => '會議準備',
            'rejected' => '被退件',
            'in_conference' => '審查會議',
            'closed' => '通過',
        ];
        return $rule[$status];
    }

    public function __construct()
    {
        $this->applicationModel = $this->model('Application');
        $this->applicationFileModel = $this->model('ApplicationFile');
        $this->applicationInformationModel = $this->model('ApplicationInformation');
        $this->applicationForeignVesselModel = $this->model('ApplicationForeignVessel');
        $this->applicationVesselRequirementModel = $this->model('ApplicationVesselRequirement');
        $this->vesselModel = $this->model('Vessel');
        $this->vesselDetailModel = $this->model('VesselDetail');
        $this->windFarmModel = $this->model('WindFarm');
        $this->vesselCategoryModel = $this->model('VesselCategory');
        $this->CountriesModel = $this->model('Country');
    }

    private function getButtons(?int $applicationId, int $page): array
    {
        $submitted = isset($applicationId) && $this->applicationModel->getById($applicationId)['status'] !== 'edited';
        $styles = array_fill(0, 5, 'secondary');
        $styles[$page] = 'primary';
        return [
            'style' => $submitted ? array_fill(0, 5, 'danger') : $styles,
            'disabled' => array_map(
                fn ($disabled) => $disabled ? 'disabled' : '',
                $submitted ? array_fill(0, 5, true) : [
                    !is_null($applicationId) === false,
                    is_null($applicationId) || $this->applicationInformationModel->getByApplicationId($applicationId) === false,
                    is_null($applicationId) || $this->applicationVesselRequirementModel->getByApplicationId($applicationId) === false,
                    is_null($applicationId) || $this->applicationForeignVesselModel->getByApplicationId($applicationId) === false,
                    is_null($applicationId) || $this->applicationFileModel->retrieveByApplicationId($applicationId) === false,
                ]
            ),
        ];
    }
    public function convertStatustoType($status)
    {
        $mappingtype = [
            "submitted" => null,
            "prepare_conference" => null,
            "in_conference" => "conference_notice",
            "closed" => ["conference_record", "consent_letter"],
            "edited" => null,
        ];
        return $mappingtype["$status"];
    }
    // 申請案管理頁面
    public function showApplicationManage(): void
    {
        $applications = $this->applicationModel->getAllByApplicantId($_SESSION['id']);
        $applications = array_map(function ($item) {
            $item['statusText'] = $this->convertStatusFromEnglishToChinese($item['status']);
            $item['statustype'] = $this->convertStatustoType($item['status']);
            if ($item['status'] == 'closed') {
                $item['download'] = $this->applicationFileModel->retrieveByApplicationIdAndType($item["id"], $item['statustype'][0])['name'] ?? null;
                $item['download2'] = $this->applicationFileModel->retrieveByApplicationIdAndType($item["id"], $item['statustype'][1])['name'] ?? null;
            } else {
                $item['download'] = $this->applicationFileModel->retrieveByApplicationIdAndType($item["id"], $item['statustype'])['name'] ?? null;
            }
            return $item;
        }, $applications);

        $applications = array_map(function ($item) {
            $item['vessel_id'] = $this->applicationForeignVesselModel->getByApplicationId($item['id'])['foreign_vessel_id'] ?? null;
            $item['vesselname'] = $item['vessel_id'] ? $this->vesselModel->getById($item['vessel_id'])['name'] : '無';
            return $item;
        }, $applications);
        $this->view('application-manage', ['applications' => $applications,]);
    }

    // 風場資料頁面
    public function showApplication(): void
    {
        $getData = $this->retrieveGetData();
        $this->view('application-case', [
            'buttons' => $this->getButtons($getData['id'] ?? null, 0),
            'windFarms' => $this->windFarmModel->getAll(),
            'vesselCategories' => $this->vesselCategoryModel->getAll(),
            'applicationId' => $getData['id'] ?? null,
            'applicationInformation' => isset($getData['id']) ? $this->applicationInformationModel->getByApplicationId($getData['id']) : null,
        ]);
    }

    public function upsertApplicationCase(): void
    {
        $postData = $this->retrievePostData();
        if ($applicationId = $postData['application_id']) {
            $this->applicationModel->update($postData);
        } else {
            $applicationId = $this->applicationModel->create($postData);
        }
        $this->redirect('./?url=page/application-requirement&id=' . $applicationId);
    }

    // 需求規格頁面
    public function showApplicationRequirement(): void
    {
        $getData = $this->retrieveGetData();
        $vesselCategoryId = $this->applicationInformationModel->getByApplicationId($getData['id'])['vessel_category_id'];
        $columns = Utils::convertEnglishToChineseForSpecificationColumns($vesselCategoryId);
        if (is_null($columns)) {
            $this->showApplicationForeignVessel();
        } else {
            $vesselDetailId = $this->applicationVesselRequirementModel->getByApplicationId($getData['id'])['vessel_detail_id'] ?? null;
            $this->view('application-requirement', [
                'buttons' => $this->getButtons($getData['id'], 1),
                'applicationId' => $getData['id'],
                'columns' => $columns,
                'vesselDetail' => $vesselDetailId ? $this->vesselDetailModel->getById($vesselDetailId) : null,
            ]);
        }
    }

    // 處理需求規格資料
    public function upsertRequirement(): void
    {
        $postData = $this->retrievePostData();
        if ($this->applicationVesselRequirementModel->getByApplicationId($postData['application_id'])) {
            $this->vesselDetailModel->update($postData);
        } else {
            $postData['vessel_detail_id'] = $this->vesselDetailModel->create($postData);
            $this->applicationVesselRequirementModel->create($postData);
        }
        $this->redirect('./?url=page/application-vessel-information&id=' . $postData['application_id']);
    }

    // 國外船舶選擇頁面
    public function showApplicationForeignVessel(): void
    {
        $getData = $this->retrieveGetData();
        $vesselCategoryId = $this->applicationInformationModel->getByApplicationId($getData['id'])['vessel_category_id'];
        $vessels = $this->vesselModel->getForeignVesselByVesselCategoryId($vesselCategoryId);
        $vessel = $this->applicationForeignVesselModel->getByApplicationId($getData['id']);
        $this->view('application-foreign-vessel', [
            'buttons' => $this->getButtons($getData['id'], 2),
            'applicationId' => $getData['id'],
            'vessels' => $vessels,
            'vessel' => $vessel,
        ]);
    }

    // 處理國外船舶資料
    public function upsertApplicationVessel(): void
    {
        $postData = $this->retrievePostData();
        if ($this->applicationForeignVesselModel->getByApplicationId($postData['application_id'])) {
            $this->applicationForeignVesselModel->update($postData);
        } else {
            $this->applicationForeignVesselModel->create($postData);
        }
        $this->redirect('./?url=page/application-content&id=' . $postData['application_id']);
    }
    private function validDataforTable(array &$data, $table_name): array
    {
        $column_names = $this->vesselModel->getColumnsName($table_name);
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
    //新增修改國外船舶規格
    public function showApplicationVesselInformation(): void
    {
        $getData = $this->retrieveGetData();
        $countries = $this->CountriesModel->getAllCountries();
        $vesselCategoryId = $this->applicationInformationModel->getByApplicationId($getData['id'])['vessel_category_id'];
        $vesselCategoryName = $this->vesselCategoryModel->getCategoryNameById($vesselCategoryId);
        $columns = Utils::convertEnglishToChineseForSpecificationColumns($vesselCategoryId);
        if ($this->applicationForeignVesselModel->getByApplicationId($getData['id'])) {
            $data = $this->applicationForeignVesselModel->getWholeVesselById($getData['id']);
            $data += $this->vesselDetailModel->getById($data['vessel_detail_id']);
            // var_dump($data);
            //  $data ? $this->applicationForeignVesselModel->getWholeVesselById($getData['id']) : null;
        }
        $this->view(
            'application-vessel-information',
            [
                'buttons' => $this->getButtons($getData['id'], 2),
                'applicationId' => $getData['id'],
                'countries' => $countries,
                'columns' => $columns,
                'vesselCategoryName' => $vesselCategoryName,
                'application_vessel' => $data ?? null
            ]
        );
    }
    //處理國外船規格
    public function upsertApplicationVesselInformation()
    {
        $PostData = $this->retrievePostData();
        // var_dump($PostData);
        //update
        $Vessel=$this->applicationForeignVesselModel->getByApplicationId($PostData['application_id']);
        var_dump($Vessel);
        if ($Vessel) {
            echo"sucessful";
            $VesselDetail = $this->validDataforTable($PostData, 'vessel_details');
            $VesselDetail['id']=$Vessel['vessel_detail_id'];
            $PostData['vessel_detail_id'] = $VesselDetail['id'];
            //var_dump($VesselDetail);
            $this->applicationForeignVesselModel->updateVesselDatatoTable($VesselDetail, 'vessel_details',true);
            $PostData['vessel_category_id'] =$Vessel['vessel_category_id'];
            //vessel_manufactured
            if ((!empty($PostData['manufactured_country_name'])) || (!empty($PostData['shipyard'])) || (!empty($PostData['manufactured_at_year'])) || (!empty($PostData['ship_class']))) {
                $manufacturedTableData = $this->validDataforTable($PostData, 'vessel_manufactured_information');
                $manufacturedTableData['id']=$Vessel['manufactured_information_id'];
                $this->applicationForeignVesselModel->updateVesselDataToTable($manufacturedTableData, 'vessel_manufactured_information',true);
            }
            $PostData += ['is_foriegn' => "1", 'status' => 'approved',];
            $ForeignVessel = $this->validDataforTable($PostData, 'application_foreign_vessel');
            $ForeignVessel['id']=$Vessel['id'];
            $this->applicationForeignVesselModel->updateVesselDataToTable($ForeignVessel, 'application_foreign_vessel',false);
        //create
        } else {
            $VesselDetail = $this->validDataforTable($PostData, 'vessel_details');
            $this->applicationForeignVesselModel->addVesselDataToTable($VesselDetail, 'vessel_details');
            $PostData['vessel_detail_id'] = $this->applicationForeignVesselModel->getLastIdByTableName('vessel_details', 'vessel_detail')['vessel_detail_id'];
            $PostData['vessel_category_id'] = $this->applicationInformationModel->getByApplicationId($PostData['application_id'])['vessel_category_id'];
            //vessel_manufactured
            if ((!empty($PostData['manufactured_country_name'])) || (!empty($PostData['shipyard'])) || (!empty($PostData['manufactured_at_year'])) || (!empty($PostData['ship_class']))) {
                $PostData += $this->vesselModel->getNextIdByTableName('vessel_manufactured_information', 'manufactured_information');
                $manufacturedTableData = $this->validDataforTable($PostData, 'vessel_manufactured_information');
                $this->vesselModel->addVesselDataToTable($manufacturedTableData, 'vessel_manufactured_information');
            }
            $PostData += ['is_foriegn' => "1", 'status' => 'approved',];
            $ForeignVessel = $this->validDataforTable($PostData, 'application_foreign_vessel');
            $this->applicationForeignVesselModel->addVesselDataToTable($ForeignVessel, 'application_foreign_vessel');
        }
        $this->redirect('./?url=page/application-upload-shipfile&id=' . $PostData['application_id']);
    }
    //上傳船舶檔案
    public function showApplicationUploadShipFile(): void
    {
        $getData = $this->retrieveGetData();
        $files = $this->applicationFileModel->retrieveByApplicationId($getData['id']);
        $this->view('application-upload-shipfile', [
            'buttons' => $this->getButtons($getData['id'], 3),
            'applicationId' => $getData['id'],
            'file' =>$files
        ]);
    }
    public function upsertApplicationShipFile():void
    {
        $PostData=$this->retrieveGetData();
        $getData=$this->retrieveGetData();
        $targetDirectory = "./uploads/application/" . $getData['id'];
        if (!is_dir($targetDirectory)) {
            mkdir($targetDirectory, 0777, true);
        }
        //船級證書
        $targetFilePath1 = $targetDirectory . "/船級證書." . pathinfo($_FILES['certificate_of_classification']['name'], PATHINFO_EXTENSION);
        if(file_exists($targetFilePath1)){
        unlink($targetFilePath1);
        move_uploaded_file($_FILES['certificate_of_classification']['tmp_name'], $targetFilePath1);
        }else{
            move_uploaded_file($_FILES['certificate_of_classification']['tmp_name'], $targetFilePath1);
            $this->applicationFileModel->create($PostData['id'], $targetFilePath1, 'certificate_of_classification');
        }
        //船舶規格
        $targetFilePath2 = $targetDirectory . "/船舶規格書." . pathinfo($_FILES['specification']['name'], PATHINFO_EXTENSION);
        if(file_exists($targetFilePath2)){
            unlink($targetFilePath2);
            move_uploaded_file($_FILES['specification']['tmp_name'], $targetFilePath2);
        }
        else{
            move_uploaded_file($_FILES['specification']['tmp_name'], $targetFilePath2);
            $this->applicationFileModel->create($PostData['id'], $targetFilePath2, 'specification');
        }
        
       //其他資料
        if($_FILES['reference']['tmp_name']!=null){
            $targetFilePath3 = $targetDirectory . "/其他資料." . pathinfo($_FILES['reference']['name'], PATHINFO_EXTENSION);
            if(file_exists($targetFilePath3)){
                unlink($targetFilePath3);
                move_uploaded_file($_FILES['reference']['tmp_name'], $targetFilePath3);
            }
            else{
            move_uploaded_file($_FILES['reference']['tmp_name'], $targetFilePath3);
            $this->applicationFileModel->create($PostData['id'], $targetFilePath3, 'reference');
            }
        }
        $this->redirect('./?url=page/application-content&id=' . $getData['id']);
    }
    // 顯示先前填過的所有資訊
    public function showApplicationContent(): void
    {
        $getData = $this->retrieveGetData();
        $data = $this->applicationModel->getFullDataById($getData['id']);
        $vessel=$this->applicationForeignVesselModel->getWholeVesselById($getData['id']);
        $vessel += $this->vesselDetailModel->getById($vessel['vessel_detail_id']);
        $columns = Utils::convertEnglishToChineseForSpecificationColumns($data['vessel_category_id']);
        $this->view('application-content', [
            'buttons' => $this->getButtons($getData['id'], 4),
            'applicationId' => $getData['id'],
            'application' => $data,
            'vessel' => $vessel,
            'file' =>$this->applicationFileModel->retrieveByApplicationId($getData['id']),
            'columns' => $columns,
            'edited' => $this->applicationModel->getById($getData['id'])['status'] == 'edited',
        ]);
    }

    public function submitApplicationContent(): void
    {
        $getData = $this->retrieveGetData();
        $this->applicationModel->updateStatusById($getData['id'], 'submitted');
        $this->redirect('./?url=page/application-content&id=' . $getData['id']);
    }

    // 填表階段頁面
    public function applicationStage(): void
    {
        $getData = $this->retrieveGetData();
        if($this->applicationFileModel->retrieveByApplicationId($getData['id'])){
            $this->showApplicationContent();
        }
        elseif ($this->applicationForeignVesselModel->getByApplicationId($getData['id'])) {
            $this->showApplicationUploadShipFile();
        } elseif ($this->applicationVesselRequirementModel->getByApplicationId($getData['id'])) {
            $this->showApplicationVesselInformation();
        } elseif ($this->applicationInformationModel->getByApplicationId($getData['id'])) {
            $this->showApplicationRequirement();
        } else {
            $this->showApplication();
        }
    }

    public function applicationManagement(): void
    {
        $getData = $this->retrieveGetData();
        $status = empty($getData['status']) ? "submitted" : $getData['status'];
        $this->view('admin/application-manage', [
            'applications' => $this->applicationModel->retrieveByStatus($status),
            'status' => $this->convertStatusFromEnglishToChinese($status),
        ]);
    }

    public function retrieveByAdmin(): void
    {
        $getData = $this->retrieveGetData();
        $data = $this->applicationModel->retrieve($getData['id']);
        $vesselData = $this->vesselModel->getWholeVesselById($data['foreign_vessel_id']);
        if (!empty($vesselData['vessel_detail_id'])) {
            $vesselSpecifications = $this->vesselDetailModel->retriveDetailById($vesselData['vessel_detail_id']);
            $vesselSpecifications = $this->convertSpecifications($vesselData['vessel_category_id'], $vesselSpecifications);
            $vesselData = array_merge($vesselData, $vesselSpecifications);
        }
        $data['foreign_vessel'] = $vesselData;
        $data['status'] = $this->convertStatusFromEnglishToChinese($data['status']);
        $files = $this->applicationFileModel->retrieveByApplicationId($getData['id']);
        foreach ($files as $file) {
            $data['files'][$file['type']] = $file;
        }
        $this->view('admin/application-information', $data);
    }

    //convertEnglishToChineseForSpecificationColumns
    public function convertSpecifications($category, $vesselSpecifications = []): array
    {
        $categoryMappings = [
            1 => [
                'specification_1' => '最大吊重(t)',
                'specification_2' => '最大吊高(m)',
                'specification_3' => '最大吊重半徑(m)',
                'specification_4' => '作業水深(m)',
                'specification_5' => '其他設備(備註)',
            ],
            2 => [
                'specification_1' => '支撐腳長(m)',
                'specification_2' => '最大吊重(t)',
                'specification_3' => '最大吊高(m)',
                'specification_4' => '最大吊重半徑(m)',
                'specification_5' => '作業水深(m)',
                'specification_6' => '其他設備(備註)',
            ],
            3 => [
                'specification_1' => '盤纜槽裝載量(t)',
                'specification_2' => '作業水深(m)',
                'specification_3' => '其他設備(備註)',
            ],
            4 => [
                'specification_1' => '裝載量能(t)',
                'specification_2' => '工作速度(t/hr)',
                'specification_3' => '作業深度(m)',
                'specification_4' => '其他設備(備註)',
            ],
            5 => [
                'specification_1' => '裝載量能(t)',
                'specification_2' => '工作速度(t/hr)',
                'specification_3' => '作業深度(m)',
                'specification_4' => '其他設備(備註)',
            ],
            6 => [
                'specification_1' => '繫纜拖力(t)',
                'specification_2' => '其他設備(備註)',
            ],
            7 => [
                'specification_1' => '繫纜拖力(t)',
                'specification_2' => '其他設備(備註)',
            ],
            8 => [
                'specification_1' => '其他設備(備註)',
            ],
            9 => [
                'specification_1' => '動態補償舷梯',
                'specification_2' => '床位數(POB)',
                'specification_3' => '其他設備(備註)',
            ],
            14 => [
                'specification_1' => '床位數(POB)',
                'specification_2' => '其他設備(備註)',
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
                if (isset($vesselSpecifications[$key])) {
                    $specifications[$label] = $vesselSpecifications[$key];
                } else {
                    $specifications[$label] = "";
                }
            }
        }
        return $specifications;
    }

    public function approvePretrial()
    {
        $getData = $this->retrieveGetData();
        $this->applicationModel->updateStatusById($getData['id'], 'prepare_conference');
        $this->redirect('?url=page/applications/application&id=' . $getData['id']);
    }

    public function reject()
    {
        $getData = $this->retrieveGetData();
        $this->applicationModel->updateStatusById($getData['id'], 'rejected');
        $this->redirect('?url=page/applications/application&id=' . $getData['id']);
    }

    public function heldConference()
    {
        $getData = $this->retrieveGetData();
        $postData = $this->retrievePostData();

        $targetDirectory = "./uploads/application/" . $getData['id'];
        if (!is_dir($targetDirectory)) {
            mkdir($targetDirectory, 0777, true);
        }

        $targetFilePath = $targetDirectory . "/申請函文." . pathinfo($_FILES['application_letter']['name'], PATHINFO_EXTENSION);
        move_uploaded_file($_FILES['application_letter']['tmp_name'], $targetFilePath);
        $this->applicationFileModel->create($getData['id'], $targetFilePath, 'application_letter');

        $targetFilePath = $targetDirectory . "/開會通知單." . pathinfo($_FILES['conference_notice']['name'], PATHINFO_EXTENSION);
        move_uploaded_file($_FILES['conference_notice']['tmp_name'], $targetFilePath);
        $this->applicationFileModel->create($getData['id'], $targetFilePath, 'conference_notice');

        $this->applicationModel->updateStatusAndOfficialDocumentNumberById($getData['id'], 'in_conference', $postData['official_document_number']);
        $this->redirect('?url=page/applications/application&id=' . $getData['id']);
    }

    public function close()
    {
        $getData = $this->retrieveGetData();
        $postData = $this->retrievePostData();
        $targetDirectory = "./uploads/application/" . $getData['id'];

        $targetFilePath = $targetDirectory . "/會議記錄." . pathinfo($_FILES['conference_record']['name'], PATHINFO_EXTENSION);
        move_uploaded_file($_FILES['conference_record']['tmp_name'], $targetFilePath);
        $this->applicationFileModel->create($getData['id'], $targetFilePath, 'conference_record');

        $targetFilePath = $targetDirectory . "/同意函." . pathinfo($_FILES['consent_letter']['name'], PATHINFO_EXTENSION);
        move_uploaded_file($_FILES['consent_letter']['tmp_name'], $targetFilePath);
        $this->applicationFileModel->create($getData['id'], $targetFilePath, 'consent_letter');
        $this->applicationModel->updateStatusAndApprovedSailingDateAndApprovedReturnDateById(
            $getData['id'],
            'closed',
            $postData['approved_sailing_date'],
            $postData['approved_return_date']
        );
        $this->redirect('?url=page/applications/application&id=' . $getData['id']);
    }
}
