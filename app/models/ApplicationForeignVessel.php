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
    public function addVesselDataToTable($data, $table_name){
        $query = $this->generateInsertSQL($data, $table_name);
        $this->db->query($query);
        foreach($data as $index => $value){
            $this->db->bind($index, $value);
        }
        $this->db->execute();
    }
    private function generateInsertSQL(array $data, string $table_name): string
    {
        $valid_columns = [];
        foreach($data as $index => $item){
            $valid_columns[] = $index;
        }
        $columns = implode(",", $valid_columns);
        $placeholders = implode(",", array_map(function($col) {
            return ':' . $col;
        }, $valid_columns));
        $sql = "INSERT INTO $table_name ($columns) VALUES ($placeholders)";
        return $sql;
    }
    public function updateVesselDatatoTable($data,$table_name,$is_id){
        if($is_id){
            $query = $this->generateUpdateSQLById($data,$table_name);
        }
        else{
            $query = $this->generateUpdateSQLByApplicationId($data,$table_name);
        }
        $this->db->query($query);
        foreach($data as $index => $value){
            $this->db->bind($index, $value);
        }
        $this->db->bind('id', $data['id']);
        $this->db->execute();

    }
    private function generateUpdateSQLByApplicationid(array $data, string $table_name): string
    {
        $set_clause = [];
        foreach ($data as $column => $value) {
            $set_clause[] = "`$column` = :$column";
        }
        $set_clause_str = implode(', ', $set_clause);
        $sql = "UPDATE `$table_name` SET $set_clause_str WHERE `application_id` =:application_id";

        return $sql;
    }
    private function generateUpdateSQLById(array $data, string $table_name): string
    {
        $set_clause = [];
        foreach ($data as $column => $value) {
            $set_clause[] = "`$column` = :$column";
        }
        $set_clause_str = implode(', ', $set_clause);
        $sql = "UPDATE `$table_name` SET $set_clause_str WHERE `id` =:id";

        return $sql;
    }
    
    public function getLastIdByTableName($table_name,$column_name){
        $query = "SELECT MAX(id) AS  {$column_name}_id FROM $table_name";
        $this->db->query($query);
        return $this->db->getSingle();
    }
    public function getWholeVesselById($id){
        $query =  "SELECT V.*, VC.vessel_category_name,
                    C1.name AS country_name, C1.code_name AS code_name, C1.flag_image_path AS flag_image_path,
                    VMI.shipyard, VMI.manufactured_country_id, VMI.manufactured_at_year, VMI.ship_class,
                    C2.name AS manufactured_country_name, C2.code_name AS manufactured_country_code_name, C2.flag_image_path AS manufactured_country_flag_image_path
                    FROM `application_foreign_vessel` AS V
                    LEFT JOIN `vessel_categories` AS VC ON V.vessel_category_id = VC.id
                    LEFT JOIN `countries` AS C1 ON V.country_id = C1.id
                    LEFT JOIN `vessel_manufactured_information` AS VMI ON V.manufactured_information_id = VMI.id
                    LEFT JOIN `countries` AS C2 ON VMI.manufactured_country_id = C2.id
                    WHERE V.application_id = :id;";
        $this->db->query($query);
        $this->db->bind('id',$id);
        return $this->db->getSingle();
    }

}