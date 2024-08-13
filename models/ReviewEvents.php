<?php
Class ReviewEvents{

    private Database $db;
    
    public function __construct(){
        $this->db = new Database();
    }

    public function getShipTimeByVesselId($id){
        $query =  "SELECT  `id` AS `review_events_id`,`start_shipment_time`,`end_shipment_time` FROM `review_events` WHERE `vessel_info_id`=:id";
        $this->db->query($query);
        $this->db->bind('id',$id);
        return $this->db->getSingle();
    }
}