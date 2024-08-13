<?php

Class AnnouncementFile {
    private Database $db;

    public function __construct(){
        $this->db = new Database();
    }

    public function retreiveByAnnouncementId($announcement_id){
        $query = "SELECT * FROM `announced_files` WHERE `announcement_id` = :announcement_id";
        $this->db->query($query);
        $this->db->bind('announcement_id', $announcement_id);
        return $this->db->getAll();
    }
}