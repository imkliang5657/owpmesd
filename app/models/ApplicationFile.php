<?php

class ApplicationFile
{
    private Database $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function create($application_id, $name, $type): void
    {
        $query = "INSERT INTO `application_files` (`application_id`, `name`, `type`) 
                    VALUES (:application_id, :name, :type)";
        $this->db->query($query);
        $this->db->bind(':application_id', $application_id);
        $this->db->bind(':name', $name);
        $this->db->bind(':type', $type);
        $this->db->execute();
    }
    public function update($application_id, $name, $type): void
    {
        $query = "UPDATE `application_files` SET  `name`=:name WHERE `application_id`=:application_id and `type`=:type "
               ;
        $this->db->query($query);
        $this->db->bind(':application_id', $application_id);
        $this->db->bind(':name', $name);
        $this->db->bind(':type', $type);
        $this->db->execute();
    }


    public function retrieveByApplicationId($id): array|bool
    {
        $query = "SELECT * FROM `application_files` WHERE `application_id` = :id";
        $this->db->query($query);
        $this->db->bind(':id', $id);
        return $this->db->getAll();
    }
    public function retrieveByApplicationIdAndType($id,$type): array|bool{
        $query = "SELECT * FROM `application_files` WHERE `application_id` = :id and `type`=:type";
        $this->db->query($query);
        $this->db->bind(':id', $id);
        $this->db->bind(':type', $type);
        return $this->db->getSingle();
    }

    
}