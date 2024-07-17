<?php

class ApplicationVesselRequirement
{
    private Database $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAll(): array|bool
    {
        $query = 'SELECT * FROM `application_vessel_requirements`';
        $this->db->query($query);
        return $this->db->getAll();
    }

    public function getByApplicationId(int $id): mixed
    {
        $query = 'SELECT * FROM `application_vessel_requirements` WHERE `application_id`=:id';
        $this->db->query($query);
        $this->db->bind(':id', $id);
        return $this->db->getSingle();
    }

    public function create(array $data): void
    {
        $query = <<<SQL
            INSERT INTO `application_vessel_requirements`(`application_id`, `vessel_detail_id`)
            VALUES(:application_id, :vessel_detail_id)
        SQL;
        $this->db->query($query);
        $this->db->bind(':application_id', $data['application_id']);
        $this->db->bind(':vessel_detail_id', $data['vessel_detail_id']);
        $this->db->execute();
    }
}