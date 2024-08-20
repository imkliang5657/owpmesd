<?php

class VesselCategorySpec
{
    private Database $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAllColunms($table_name): array|bool
    {
        $query = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$table_name'";
        $this->db->query($query);
        return $this->db->getAll();
    }
}