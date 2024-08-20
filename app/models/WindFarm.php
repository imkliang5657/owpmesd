<?php

class WindFarm
{
    private Database $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAll(): array|bool
    {
        $query = 'SELECT * FROM `wind_farms`';
        $this->db->query($query);
        return $this->db->getAll();
    }

    public function getById(int $id): mixed
    {
        $query = 'SELECT * FROM `wind_farms` WHERE `id`=:id';
        $this->db->query($query);
        $this->db->bind(':id', $id);
        return $this->db->getSingle();
    }
}