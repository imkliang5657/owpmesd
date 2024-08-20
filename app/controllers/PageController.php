<?php

Class PageController extends Controller
{
    private mixed $vesselCategoryModel;
    private mixed $vesselModel;

    public function __construct(){
        $this->vesselCategoryModel = $this->model('VesselCategory');
        $this->countries = $this->model('Country');
        $this->vesselModel = $this->model('Vessel');
    }
    public function dashboard() {
        $this->view('dashboard');
    }

    public function shipDatabaseDashboard() {
        $this->view('ship-database-dashboard');
    }
    public function shipApplicationDashboard() {
        $this->view('ship-application-dashboard');
    }

    public function login() {
        $getData = $this->retrieveGetData();
        $error = isset($getData['error']) && $getData['error'] == 1;
        $this->view('login', ['error' => $error]);
    }
}
