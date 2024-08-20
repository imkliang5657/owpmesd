<?php

Class Vessel {
    private Database $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function retriveAllDomesticVesselsWithCategory(){
        $query = "SELECT V.id, V.name, V.vessel_category_id,V.updated_at, VC.vessel_category_name AS category 
                FROM `vessels` AS V
                LEFT JOIN `vessel_categories` AS VC ON V.vessel_category_id = VC.id 
                WHERE V.is_foriegn = 0 AND V.status = 'approved'
                ORDER BY V.vessel_category_id ASC";
        $this->db->query($query);
        return $this->db->getAll();
    }

    public function retriveSpeciticationPathById($id){
        $query = "SELECT `specification` FROM `vessels` WHERE `id`=:id";
        $this->db->query($query);
        $this->db->bind('id',$id);
        return $this->db->getSingle();
    }

    public function getWholeVesselById($id){
        $query =  "SELECT V.*, VC.vessel_category_name,
                    C1.name AS country_name, C1.code_name AS code_name, C1.flag_image_path AS flag_image_path,
                    VMI.shipyard, VMI.manufactured_country_id, VMI.manufactured_at_year, VMI.ship_class,
                    C2.name AS manufactured_country_name, C2.code_name AS manufactured_country_code_name, C2.flag_image_path AS manufactured_country_flag_image_path
                    FROM `vessels` AS V
                    LEFT JOIN `vessel_categories` AS VC ON V.vessel_category_id = VC.id
                    LEFT JOIN `countries` AS C1 ON V.country_id = C1.id
                    LEFT JOIN `vessel_manufactured_information` AS VMI ON V.manufactured_information_id = VMI.id
                    LEFT JOIN `countries` AS C2 ON VMI.manufactured_country_id = C2.id
                    WHERE V.id = :id;";
        $this->db->query($query);
        $this->db->bind('id',$id);
        return $this->db->getSingle();
    }

    public function getIdNameByCategory($category_name){
        $query = "SELECT V.id,V.name FROM `vessels` as V
                 JOIN `vessel_categories` AS VC ON V.vessel_category_id = VC.id
                 WHERE VC.vessel_category_name = :category_name
                 AND V.is_foriegn = 0
                 AND V.status = 'approved'";
        $this->db->query($query);
        $this->db->bind('category_name',$category_name);
        return $this->db->getAll();

    }

    public function getVesselByIMO($IMO) {
        $query = "SELECT * FROM vessels WHERE IMO = :IMO";
        $this->db->query($query);
        $this->db->bind('IMO', $IMO);
        return $this->db->getSingle();
    }

    public function getVesselByMMSI($MMSI) {
        $query = "SELECT * FROM vessels WHERE MMSI = :MMSI";
        $this->db->query($query);
        $this->db->bind('MMSI', $MMSI);
        return $this->db->getSingle();
    }

    public function getVesselByName($name) {
        $query = "SELECT * FROM vessels WHERE name = :name";
        $this->db->query($query);
        $this->db->bind('name', $name);
        return $this->db->getSingle();
    }

    public function getNextIdByTableName($table_name,$column_name){
        $query = "SELECT MAX(id) + 1 AS  {$column_name}_id FROM $table_name";
        $this->db->query($query);
        return $this->db->getSingle();
    }
    public function getLastIdByTableName($table_name,$column_name){
        $query = "SELECT MAX(id) AS  {$column_name}_id FROM $table_name";
        $this->db->query($query);
        return $this->db->getSingle();
    }

    public function getColumnsName($table_name){
        $query = "SELECT column_name
                FROM information_schema.columns
                WHERE table_name = '$table_name'
                AND column_name != 'id'";
        $this->db->query($query);
        return $this->db->getAll();
    }

    public function addVesselDataToTable($data, $table_name){
        $query = $this->generateInsertSQL($data, $table_name);
        $this->db->query($query);
        foreach($data as $index => $value){
            $this->db->bind($index, $value);
        }
        $this->db->execute();
    }

    public function updateVesselDatatoTable($data,$table_name){
        $query = $this->generateUpdateSQL($data,$table_name);
        $this->db->query($query);
        foreach($data as $index => $value){
            $this->db->bind($index, $value);
        }
        $this->db->bind('id', $data['id']);
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

    private function generateUpdateSQL(array $data, string $table_name): string
    {
        $set_clause = [];
        foreach ($data as $column => $value) {
            $set_clause[] = "`$column` = :$column";
        }
        $set_clause_str = implode(', ', $set_clause);
        $sql = "UPDATE `$table_name` SET $set_clause_str WHERE `id` =:id";

        return $sql;
    }


    public function retrieveByCondition($condition): bool|array
    {
        $query = "SELECT `vessel_categories`.`vessel_category_name`, `vessel_details`.*, `countries`.`name` AS `country`, `vessels`.*
                FROM (
                    SELECT * FROM vessels 
                    WHERE (:vesselName IS NULL OR `vessels`.`name` LIKE CONCAT('%', :vesselName, '%')) 
                    AND(:vesselCategoryId IS NULL OR `vessels`.`vessel_category_id` = :vesselCategoryId)
                    AND(:imo IS NULL OR `vessels`.`imo` = :imo) 
                    AND(:mmsi IS NULL OR `vessels`.`mmsi` = :mmsi)
                    AND(:length IS NULL OR `vessels`.`length` {$condition['condition_of_length']} :length)
                    AND(:breadth IS NULL OR `vessels`.`breadth` {$condition['condition_of_breadth']} :breadth)
                    AND(:draft_min IS NULL OR `vessels`.`draft_min` {$condition['condition_of_draft_min']} :draft_min)
                    AND(:freeDeckSpace IS NULL OR `vessels`.`freeDeckSpace` {$condition['condition_of_freeDeckSpace']} :freeDeckSpace)
                ) AS vessels
                INNER JOIN vessel_categories ON `vessel_categories`.`id` = `vessels`.`vessel_category_id`
                INNER JOIN countries ON `countries`.`id` = `vessels`.`country_id`
                INNER JOIN vessel_details ON `vessel_details`.`id` = `vessels`.`vessel_detail_id`
                WHERE 
                    (
                        :crane_weight IS NULL 
                        OR (`vessels`.`vessel_category_id` = 1  AND CAST(`vessel_details`.`specification_1` AS float) {$condition['condition_of_crane_weight']} :crane_weight) 
                        OR (`vessels`.`vessel_category_id` = 2  AND CAST(`vessel_details`.`specification_2` AS float) {$condition['condition_of_crane_weight']} :crane_weight)
                    ) AND (
                        :cable_capacity IS NULL 
                        OR (`vessels`.`vessel_category_id` = 3  AND CAST(`vessel_details`.`specification_1`AS float) {$condition['condition_of_cable_capacity']} :cable_capacity) 
                    ) AND (
                        :bollard_pull_force IS NULL 
                        OR (`vessels`.`vessel_category_id` IN (6,7) AND CAST(`vessel_details`.`specification_1`AS float) {$condition['condition_of_bollard_pull_force']} :bollard_pull_force)
                    ) AND (
                        :operating_draft IS NULL
                        OR (`vessels`.`vessel_category_id` = 1  AND CAST(`vessel_details`.`specification_4`AS float) {$condition['condition_of_operating_draft']} :operating_draft)
                        OR (`vessels`.`vessel_category_id` = 2  AND CAST(`vessel_details`.`specification_5`AS float) {$condition['condition_of_operating_draft']} :operating_draft)
                        OR (`vessels`.`vessel_category_id` = 3  AND CAST(`vessel_details`.`specification_2`AS float) {$condition['condition_of_operating_draft']} :operating_draft)
                        OR (`vessels`.`vessel_category_id` IN (4, 5)  AND CAST(`vessel_details`.`specification_3`AS float) {$condition['condition_of_operating_draft']} :operating_draft)
                    )
                ";
        $this->db->query($query);
        $this->db->bind(':vesselName', $condition['vesselName']);
        $this->db->bind(':vesselCategoryId', $condition['vesselCategoryId']);
        $this->db->bind(':imo', $condition['imo']);
        $this->db->bind(':mmsi', $condition['mmsi']);
        $this->db->bind(':length', $condition['length']);
        $this->db->bind(':breadth', $condition['breadth']);
        $this->db->bind(':draft_min', $condition['draft_min']);
        $this->db->bind(':freeDeckSpace', $condition['freeDeckSpace']);
        $this->db->bind(':crane_weight', $condition['crane_weight']);
        $this->db->bind(':cable_capacity', $condition['cable_capacity']);
        $this->db->bind(':bollard_pull_force', $condition['bollard_pull_force']);
        $this->db->bind(':operating_draft', $condition['operating_draft']);
        return $this->db->getAll();
    }

    public function getAll(): array|bool
    {
        $query = 'SELECT * FROM `vessels`';
        $this->db->query($query);
        return $this->db->getAll();
    }

    public function getForeignVesselByVesselCategoryId(int $vesselCategoryId): array|bool
    {
        $query = 'SELECT * FROM `vessels` WHERE `vessel_category_id`=:vessel_category_id AND `is_foriegn` = 1';
        $this->db->query($query);
        $this->db->bind(':vessel_category_id', $vesselCategoryId);
        return $this->db->getAll();
    }

    public function getById(int $id): mixed
    {
        $query = 'SELECT * FROM `vessels` WHERE `id`=:id';
        $this->db->query($query);
        $this->db->bind(':id', $id);
        return $this->db->getSingle();
    }
}
