<?php

Class Countries{
    private Database $db;
    
    public function __construct(){
        $this->db = new Database();
    }

    public function getCountryNameById($id){
        $query = "SELECT country_name FROM countries WHERE id = :id";
        $this->db->query($query);
        $this->db->bind('id',$id);
        return $this->db->getSingle();
    }

    public function getAllCountries(){
        $query = "SELECT `id` AS `country_id`, `name` AS `country_name` FROM `countries`";
        $this->db->query($query);
        return $this->db->getAll();
    }

    public function getIdByCountryName($country_name,$column_name){
        $query = "SELECT id AS {$column_name}_id FROM `countries` WHERE `name`=:country_name";
        $this->db->query($query);
        $this->db->bind("country_name",$country_name);
        return $this->db->getSingle(); 
    }
}