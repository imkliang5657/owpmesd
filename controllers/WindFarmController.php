<?php

class WindFarmController extends Controller
{
    protected WindFarm $windFarm;
    protected WindFarmInformation $windFarmInformation;

    public function __construct()
    {
        $this->windFarm = $this->model('WindFarm');
        $this->windFarmInformation = $this->model('WindFarmInformation');
    }

    public function windFarm(): void
    {
        $this->view('wind-farm', ['windFarms' => $this->model('WindFarm')->getAll()]);
    }

    public function windFarmNewForm()
    {
        $getData = $this->retrieveGetData();
        if (isset($getData['id'])) {
            $windFarm = $this->model('WindFarm')->getByid($getData['id']);
            $this->view('wind-farm-new-form', 
            ['windFarm' => $windFarm, 
            'id' => $getData['id'],
            'vesselCategories' => $this->model('VesselCategory')->getAll()
        ]);
        } else {
            $this->redirect('./?url=page/wind-farm');
        }
    }

    public function windFarmInformation(): void
    {
        $getData = $this->retrieveGetData();
        if (isset($getData['id'])) {
            $windFarm = $this->model('WindFarm')->getByid($getData['id']);
            $this->view('wind-farm-information', [
              'windFarm' => $windFarm,
              'windFarmInformation' => $this->model('WindFarmInformation')->getByWindFarmId($windFarm['id']),
              'vesselCategories' => $this->model('VesselCategory')->getAll(),
              'id' => $getData['id']
            ]);
        } else {
            $this->redirect('./?url=page/wind-farm');
        }
    }

    public function upsertInformation(): void
    {
        $postData = $this->retrievePostData();
        if (empty($postData['id'])) {
            $this->windFarmInformation->create($postData);
        } else {
            $information = $this->windFarm->getById($postData['id']);
            if (isset($information)) {
                $this->windFarmInformation->update($postData);
            }
        }
        $this->redirect('./?url=page/wind-farm-information&id=' . $postData['wind_farm_id']);
    }
}