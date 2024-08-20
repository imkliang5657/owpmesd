<?php
class VesselCategory {
    private Database $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAllVesselCategories() {
        $query = "SELECT id AS vessel_category_id,vessel_category_name  FROM `vessel_categories`";
        $this->db->query($query);
        return $this->db->getAll();
    }

    public function getIdByVesselCategoryName($vessel_category_name){
        $query = "SELECT `id` AS `vessel_category_id` FROM `vessel_categories` WHERE `vessel_category_name`=:vessel_category_name";
        $this->db->query($query);
        $this->db->bind("vessel_category_name",$vessel_category_name);
        return $this->db->getSingle();
    }

    public function getCategoryNameById($vessel_category_id){
        $query = "SELECT `vessel_category_name` FROM `vessel_categories` WHERE `id`=:vessel_category_id";
        $this->db->query($query);
        $this->db->bind("vessel_category_id",$vessel_category_id);
        return $this->db->getSingle();
    }

    public function getAll(): array|bool
    {
        $query = 'SELECT * FROM `vessel_categories`';
        $this->db->query($query);
        return $this->db->getAll();
    }

    public function getById(int $id): mixed
    {
        $query = 'SELECT * FROM `vessel_categories` WHERE `id`=:id';
        $this->db->query($query);
        $this->db->bind(':id', $id);
        return $this->db->getSingle();
    }
}