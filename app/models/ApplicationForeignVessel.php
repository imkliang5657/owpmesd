<?php

class ApplicationForeignVessel
{
    private Database $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAll(): array|bool
    {
        $query = 'SELECT * FROM `application_foreign_vessel`';
        $this->db->query($query);
        return $this->db->getAll();
    }

    public function getByApplicationId(int $id): mixed
    {
        $query = 'SELECT * FROM `application_foreign_vessel` WHERE `application_id`=:id';
        $this->db->query($query);
        $this->db->bind(':id', $id);
        return $this->db->getSingle();
    }

    public function create(array $data): void
    {
        $query = <<<SQL
            INSERT INTO `application_foreign_vessel`(`foreign_vessel_id`, `application_id`) 
            VALUES (:foreign_vessel_id, :application_id)
        SQL;
        $this->db->query($query);
        $this->db->bind(':foreign_vessel_id', $data['foreign_vessel_id']);
        $this->db->bind(':application_id', $data['application_id']);
        $this->db->execute();
    }

    public function update(array $data): void
    {
        $query = <<<SQL
            UPDATE
                `application_foreign_vessel`
            SET
                `foreign_vessel_id`=:foreign_vessel_id,
                `application_id`=:application_id
            WHERE
                `id`=:id
        SQL;
        $this->db->query($query);
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':foreign_vessel_id', $data['foreign_vessel_id']);
        $this->db->bind(':application_id', $data['application_id']);
        $this->db->execute();
    }
}