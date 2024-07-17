<?php

class Log {

    private Database $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getIdInTwoWeeks(){
        $query= "SELECT l1.vessel_id, l1.operation
        FROM log l1
        INNER JOIN (
            SELECT vessel_id, MAX(operated_at) AS max_operated_at
            FROM log
            WHERE operated_at >= NOW() - INTERVAL 2 WEEK
            GROUP BY vessel_id
        ) l2 ON l1.vessel_id = l2.vessel_id AND l1.operated_at = l2.max_operated_at
        ORDER BY l1.operated_at DESC";
        $this->db->query($query);
        return $this->db->getAll();
    }
}