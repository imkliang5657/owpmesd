<?php

class VesselController extends Controller
{
    private mixed $vesselCategoryModel;
    private mixed $vesselModel;

    public function __construct(){
        $this->vesselCategoryModel = $this->model('VesselCategory');
        $this->vesselModel = $this->model('Vessel');
    }

    public function searchVessel() {
        $vesselCategories = $this->vesselCategoryModel->getAll();
        $getData = $this->retrieveGetData();
        if ($getData == []) {
            $this->view('search-vessel', ['vesselCategories' => $vesselCategories, 'vessels' => []]);
        } else {
            foreach ($getData as $key => $value) {
                $getData[$key] = empty($value) ? NULL : $value;
            }
            $vessels = $this->vesselModel->retrieveByCondition($getData);
            foreach ($vessels as $index => $vessel) {
                $detail_column = Utils::getSpecificationColumns($vessel['vessel_category_id']);
                $vessels[$index]['crane_weight'] = in_array('crane_weight', $detail_column) ? $vessel['specification_'. (array_search('crane_weight', $detail_column) + 1)] : "none";
                $vessels[$index]['cable_capacity'] = in_array('cable_capacity', $detail_column) ? $vessel['specification_'. array_search('cable_capacity', $detail_column) + 1] : "none";
                $vessels[$index]['bollard_pull_force'] = in_array('bollard_pull_force', $detail_column) ? $vessel['specification_'. array_search('bollard_pull_force', $detail_column) + 1] : "none";
                $vessels[$index]['operating_draft'] = in_array('operating_draft', $detail_column) ? $vessel['specification_'. array_search('operating_draft', $detail_column) + 1] : "none";
            }
            $this->view('search-vessel', ['vesselCategories' => $vesselCategories, 'vessels' => $vessels]);
        }
    }
}