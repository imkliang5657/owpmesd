<?php

class VesselDetail {
    private Database $db;

    const MAX_SPEC_COUNT = 7;

    public function __construct() {
        $this->db = new Database();
    }

    public static function columns(): array
    {
        return array_map(fn($i) => "specification_$i", range(1, self::MAX_SPEC_COUNT));
    }

    public function getById(int $id): mixed
    {
        $query = 'SELECT * FROM `vessel_details` WHERE `id`=:id';
        $this->db->query($query);
        $this->db->bind(':id', $id);
        return $this->db->getSingle();
    }

    public function create(array $data): int
    {
        $columns = self::columns();
        $placeholders = array_map(fn($column) => ':' . $column, $columns);
        $values = array_values(array_intersect_key($data, array_flip($columns)));
        $columnsStr = implode(', ', array_map(fn($column) => "`$column`", $columns));
        $placeholdersStr = implode(', ', $placeholders);
        $query = <<<SQL
            INSERT INTO `vessel_details`($columnsStr)
            VALUES ($placeholdersStr)
        SQL;
        $this->db->query($query);
        for ($i = 0; $i < self::MAX_SPEC_COUNT; $i++) {
            $this->db->bind($placeholders[$i], $values[$i]);
        }
        $this->db->execute();

        $query = <<<SQL
            SELECT LAST_INSERT_ID() as `id`
        SQL;
        $this->db->query($query);
        $this->db->execute();
        return $this->db->getSingle()['id'];
    }

    public function update(array $data): void
    {
        $columns = self::columns();
        $placeholders = array_map(fn($column) => ':' . $column, $columns);
        $values = array_values(array_intersect_key($data, array_flip($columns)));
        $combinedStr =  implode(', ', array_map(fn($column, $placeholder) => "`$column`=$placeholder", $columns, $placeholders));
        $query = <<<SQL
            UPDATE `vessel_details` SET $combinedStr WHERE `id`=:id
        SQL;
        $this->db->query($query);
        $this->db->bind(':id', $data['id']);
        for ($i = 0; $i < self::MAX_SPEC_COUNT; $i++) {
            $this->db->bind($placeholders[$i], $values[$i]);
        }
        $this->db->execute();
    }

    public function lastInsertId(): int
    {
        $query = 'SELECT LAST_INSERT_ID() as id';
        $this->db->query($query);
        $this->db->execute();
        return $this->db->getSingle()['id'];
    }


    public function getAll(): array|bool
    {
        $query = 'SELECT * FROM `vessel_details`';
        $this->db->query($query);
        return $this->db->getAll();
    }

    public function retriveDetailById($vessel_detail_id){
        $query =  "SELECT * FROM `vessel_details` WHERE `id`=:vessel_detail_id";
        $this->db->query($query);
        $this->db->bind('vessel_detail_id',$vessel_detail_id);
        return $this->db->getSingle();
    }

    public function getNextId(){
        $query = "SELECT MAX(id) + 1 AS  vessel_detail_id FROM `vessel_details`";
        $this->db->query($query);
        return $this->db->getSingle();
    }

}
