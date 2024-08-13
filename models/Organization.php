<?php

class Organization
{
    private Database $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function retrieveAll(): bool|array
    {
        $query = 'SELECT * FROM `organizations`';
        $this->db->query($query);
        return $this->db->getAll();
    }
}