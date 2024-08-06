<?php

class Api
{
    private array $routes = [
        'noRestriction' => [
            'page/login' => ['PageController', 'login'],
            'login' => ['AuthController', 'login'],
        ],
        'hasLogin' => [
            // Page
            'page/dashboard' => ['PageController', 'dashboard'],
            'page/ship-database-dashboard' => ['PageController', 'shipDatabaseDashboard'],
            'page/ship-application-dashboard' => ['PageController', 'shipApplicationDashboard'],

            'domesticShip/domestic-ship' => ['DomesticShipController', 'domesticShip'],
            'domesticShip/domestic-ship-information' => ['DomesticShipController', 'domesticShipInformation'],
            'domesticShip/domestic-category-shipment' => ['DomesticShipController', 'domesticCategoryShipment'],
            'domesticShip/create-domestic-ship' => ['DomesticShipController', 'createDomesticShip'],
            'domesticShip/add-promise-shipment' =>['DomesticShipController', 'addPromiseShipment'],
            'domesticShip/add-available-shipment' =>['DomesticShipController', 'addAvailableShipment'],
            'domesticShip/update-domestic-ship' => ['DomesticShipController', 'updateDomesticShip'],
            'domesticShip/shipment-print' => ['DomesticShipController', 'shipmentPrint'],
            'domesticShip/update-domestic-shipment' => ['DomesticShipController', 'updateDomesticShipment'],
            'domesticShip/upload' => ['DomesticShipController', 'upload'],
            'domesticShip/download' => ['DomesticShipController', 'download'],

            'page/create-application' => ['ApplicationController', 'createApplication'],
            'page/create-application-case' =>  ['ApplicationController', 'createApplicationCase'],
            'page/application-requirement-spec' => ['ApplicationController', 'requirementSpec'],
            'page/application-ship' => ['ApplicationController', 'applicationShip'],

            // WindFarm
            'page/wind-farm-newform' => ['WindFarmController', 'windFarmNewForm'],
            'page/wind-farm-information' =>['WindFarmController','windFarmInformation'],
            'upsert-wind-farm-information' =>['WindFarmController','upsertInformation'],

            // Vessel
            'page/search-vessel' => ['VesselController', 'searchVessel'],
            // Announcement
            'page/announcements' => ['AnnouncementController', 'search'],
            'page/announcements/announcement' => ['AnnouncementController', 'retrieve'],
            'page/announcements/announcement/modify' => ['AnnouncementController', 'modify'],
            'update/announcements/announcement' => ['AnnouncementController', 'update'],
            'delete/announcements/announcement' => ['AnnouncementController', 'delete'],
            'page/announcements/announcement/add' => ['AnnouncementController', 'add'],
            'create/announcements/announcement' => ['AnnouncementController', 'create'],

            // Auth
            'logout' => ['AuthController', 'logout'],

            // WindFarmController
            'page/wind-farm' => ['WindFarmController', 'windFarm'],
            'page/wind-farm-new-form' => ['WindFarmController', 'windFarmNewForm'],

            // Application Manage
            'page/applications/application' => ['ApplicationController', 'retrieveByAdmin'],
            'page/applications/manage' => ['ApplicationController', 'applicationManagement'],
            'applications/application/approve-pretrial' => ['ApplicationController', 'approvePretrial'],
            'applications/application/reject' => ['ApplicationController', 'reject'],
            'applications/application/conference-held' => ['ApplicationController', 'heldConference'],
            'applications/application/close' => ['ApplicationController', 'close'],

            // Application
            'page/application-ships' => ['ApplicationController', 'newApplicationShip'],
            'page/application-manage' => ['ApplicationController', 'showApplicationManage'],
            'page/application-case' => ['ApplicationController', 'showApplication'],
            'upsert-application-case' => ['ApplicationController', 'upsertApplicationCase'],
            'page/application-requirement' => ['ApplicationController', 'showApplicationRequirement'],
            'upsert-requirement' => ['ApplicationController', 'upsertRequirement'],
            'page/application-foreign-vessel' => ['ApplicationController', 'showApplicationForeignVessel'],
            'page/application-vessel-information' => ['ApplicationController', 'showApplicationVesselInformation'],
            'upsert-application-foreign-vessel' => ['ApplicationController', 'upsertApplicationVessel'],
            'upsert-application-foreign-vessel-information' => ['ApplicationController', 'upsertApplicationVesselInformation'],
            'page/application-upload-shipfile' =>['ApplicationController', 'showApplicationUploadShipFile'],
            'upsert-application-upload-shipfile' => ['ApplicationController', 'upsertApplicationShipFile'],
            'page/application-content' => ['ApplicationController', 'showApplicationContent'],
            'submit-application-content' => ['ApplicationController', 'submitApplicationContent'],
            'application-stage' => ['ApplicationController', 'applicationStage'],
        ],
        'onlyAdminCanUse' => []
    ];

    /**
     * @throws HttpStatusException
     */
    public function findRoute($targetRoute): array
    {
        foreach ($this->routes as $restriction => $route) {
            if (array_key_exists($targetRoute, $route)) {
				return [
					'restriction' => $restriction,
					'handler' => $route[$targetRoute]
				];
            }
        }
        throw new HttpStatusException(404, "找不到您想要瀏覽的網頁或執行的動作!");
    }

}