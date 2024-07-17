<?php

class PromiseShippingSchedule{
    private Database $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function retriveVesselScheduleByVesselId($vessel_id){
        $query =  "SELECT  `id` AS `promise_shipping_schedules_id`,`sailing_date` AS `promise_sailing_date` ,`return_date` AS `promise_return_date` 
                    FROM `promise_shipping_schedules` 
                    WHERE `vessel_id`=:vessel_id
                    ORDER BY `created_at` DESC
                    LIMIT 5";
        $this->db->query($query);
        $this->db->bind('vessel_id',$vessel_id);
        return $this->db->getAll();
    }

    public function detectShipments($vessel_id, $sailing_date, $return_date, $exclude_id = null){
        $query = "SELECT * FROM promise_shipping_schedules 
                WHERE vessel_id = :vessel_id 
            AND id != :exclude_id
            AND sailing_date <= return_date  -- 確保數據庫中的日期範圍有效
            AND :sailing_date <= :return_date  -- 確保輸入的日期範圍有效
            AND ((sailing_date <= :return_date AND return_date >= :sailing_date)
            OR (sailing_date >= :sailing_date AND sailing_date <= :return_date)
            OR (return_date >= :sailing_date AND return_date <= :return_date))";
        $this->db->query($query);
        $this->db->bind('vessel_id',$vessel_id);
        $this->db->bind('exclude_id', $exclude_id);
        $this->db->bind('sailing_date',$sailing_date);
        $this->db->bind('return_date',$return_date);
        return $this->db->getSingle();

    }

    public function insertShipment($vessel_id,$sailing_date,$return_date){
        $query = "INSERT INTO promise_shipping_schedules (vessel_id, sailing_date, return_date) 
                        VALUES (:vessel_id, :sailing_date, :return_date)";
        $this->db->query($query);
        $this->db->bind('vessel_id',$vessel_id);
        $this->db->bind('sailing_date',$sailing_date);
        $this->db->bind('return_date',$return_date);
        $this->db->execute();
       
    }

}
