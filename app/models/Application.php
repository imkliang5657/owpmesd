<?php

class Application
{
    private Database $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAllByApplicantId($applicant_id): array|bool
    {
        $query = 'SELECT * FROM `applications` WHERE `applicant_id`=:applicant_id ORDER BY `applications`.`created_at` DESC';
        $this->db->query($query);
        $this->db->bind(':applicant_id', $applicant_id);
        return $this->db->getAll();
    }

    public function getAll(): array|bool
    {
        $query = 'SELECT `applications`.*, `wind_farms`.`name` as `wind_farm` FROM `applications` 
                    INNER JOIN `application_informations` ON `application_informations`.`application_id` = `applications`.`id`
                    INNER JOIN `wind_farms` ON `wind_farms`.`id` = `application_informations`.`wind_farm_id`
                WHERE `applicant_id` = :applicant_id';
        $this->db->query($query);
        $this->db->bind(':applicant_id', $_SESSION['id']);
        return $this->db->getAll();
    }

    public function getById($id): mixed
    {
        $query = 'SELECT * FROM `applications` WHERE `id`=:id';
        $this->db->query($query);
        $this->db->bind(':id', $id);
        return $this->db->getSingle();
    }

    public function create(array $data): int
    {
        $query = <<<SQL
            INSERT INTO `applications`(`applicant_id`) VALUES ({$_SESSION['id']})
        SQL;
        $this->db->query($query);
        $this->db->execute();

        $query = <<<SQL
            SELECT LAST_INSERT_ID() as id
        SQL;
        $this->db->query($query);
        $this->db->execute();
        $application = $this->db->getSingle();

        $query = <<<SQL
            INSERT INTO
                `application_informations`(`application_id`, `wind_farm_id`, `work_item`, `vessel_category_id`, `required_sailing_date`, `required_return_date`, `description`)
            VALUES
                (:application_id, :wind_farm_id, :work_item, :vessel_category_id, :required_sailing_date, :required_return_date, :description)
        SQL;
        $this->db->query($query);
        $this->db->bind(':application_id', $application['id']);
        $this->db->bind(':wind_farm_id', $data['wind_farm_id']);
        $this->db->bind(':work_item', $data['work_item']);
        $this->db->bind(':vessel_category_id', $data['vessel_category_id']);
        $this->db->bind(':required_sailing_date', $data['required_sailing_date']);
        $this->db->bind(':required_return_date', $data['required_return_date']);
        $this->db->bind(':description', $data['description']);
        $this->db->execute();

        return $application['id'];
    }
public function update(array $data): void
    {
        $query = <<<SQL
            UPDATE
                `application_informations`
            SET
                `wind_farm_id`=:wind_farm_id,
                `work_item`=:work_item,
                `vessel_category_id`=:vessel_category_id,
                `required_sailing_date`=:required_sailing_date,
                `required_return_date`=:required_return_date,
                `description`=:description
            WHERE
                `application_id`=:application_id
        SQL;
        $this->db->query($query);
        $this->db->bind(':application_id', $data['application_id']);
        $this->db->bind(':wind_farm_id', $data['wind_farm_id']);
        $this->db->bind(':work_item', $data['work_item']);
        $this->db->bind(':vessel_category_id', $data['vessel_category_id']);
        $this->db->bind(':required_sailing_date', $data['required_sailing_date']);
        $this->db->bind(':required_return_date', $data['required_return_date']);
        $this->db->bind(':description', $data['description']);
        $this->db->execute();
    }

    public function getFullDataById(int $id): array|bool
    {
        $vdColumnStr = implode(', ', array_map(fn($column) => "vd.$column", VesselDetail::columns()));
        $query = <<<SQL
            SELECT 
                a.id, a.status, 
                u.name AS applicant_name,
                ai.work_item,
                ai.description,
                ai.required_sailing_date,
                ai.required_return_date,
                wf.name AS wind_farm_name,
                vc.id AS vessel_category_id,
                vc.vessel_category_name AS vessel_category_name,
                $vdColumnStr
            FROM 
                applications a
            JOIN
                users u ON u.id = a.applicant_id
            JOIN
                application_informations ai ON a.id = ai.application_id
            JOIN
                wind_farms wf ON wf.id = ai.wind_farm_id
            JOIN
                vessel_categories vc ON vc.id = ai.vessel_category_id
            JOIN 
                application_vessel_requirements avr ON a.id = avr.application_id
            JOIN 
                vessel_details vd ON vd.id = avr.vessel_detail_id
            JOIN 
                application_foreign_vessel afv ON a.id = afv.application_id
            WHERE 
                a.id =:id
        SQL;
        $this->db->query($query);
        $this->db->bind(':id', $id);
        return $this->db->getSingle();
    }

    public function retrieveByStatus($status): bool|array
    {
        $query = "SELECT 
                    `applications`.`id`,`applications`.`command`, `applications`.`official_document_number`, `applications`.`approved_sailing_date`, `applications`.`approved_return_date`,
                    `users`.`name` as `applicant`,
                    `wind_farms`.`name` as `wind_farm`,
                    `vessels`.`name` as `vessel`
                  FROM (SELECT * FROM `applications` WHERE `status` = :status) as `applications` 
                  INNER JOIN `users` ON `users`.`id` = `applications`.`applicant_id`
                  INNER JOIN `application_informations` ON `application_informations`.`application_id` = `applications`.`id`
                  INNER JOIN `wind_farms` ON `wind_farms`.`id` = `application_informations`.`wind_farm_id`
                  INNER JOIN `application_foreign_vessel` ON `application_foreign_vessel`.`application_id` = `applications`.`id`
                  INNER JOIN `vessels` ON `vessels`.`id` = `application_foreign_vessel`.`foreign_vessel_id`";
        $this->db->query($query);
        $this->db->bind(':status', $status);
        return $this->db->getAll();
    }

    public function retrieve($id) {
        $query = "SELECT 
                    `users`.`name` as `applicant`,
                    `application_informations`.*, `application_informations`.`id` as `application_information_id`,
                    `wind_farms`.`name` as `wind_farm`,
                    `application_foreign_vessel`.`foreign_vessel_id`,
                    `applications`.*
                  FROM (SELECT * FROM `applications` WHERE `id` = :id) as `applications` 
                  INNER JOIN `users` ON `users`.`id` = `applications`.`applicant_id`
                  INNER JOIN `application_informations` ON `application_informations`.`application_id` = `applications`.`id`
                  INNER JOIN `wind_farms` ON `wind_farms`.`id` = `application_informations`.`wind_farm_id`
                  INNER JOIN `application_foreign_vessel` ON `application_foreign_vessel`.`application_id` = `applications`.`id`";
        $this->db->query($query);
        $this->db->bind('id', $id);
        return $this->db->getSingle();
    }

    public function updateStatusById($id, $status): void
    {
        $query = "UPDATE `applications` SET `status` = :status WHERE `applications`.`id` = :id";
        $this->db->query($query);
        $this->db->bind('id', $id);
        $this->db->bind('status', $status);
        $this->db->execute();
    }

    public function updateStatusAndOfficialDocumentNumberById($id, $status, $official_document_number): void
    {
        $query = "UPDATE `applications` SET `status` = :status , `official_document_number` = :official_document_number WHERE `id` = :id";
        $this->db->query($query);
        $this->db->bind('id', $id);
        $this->db->bind('status', $status);
        $this->db->bind('official_document_number', $official_document_number);
        $this->db->execute();
    }

    public function updateStatusAndApprovedSailingDateAndApprovedReturnDateById($id, $status, $approved_sailing_date, $approved_return_date): void
    {
        $query = "UPDATE `applications` 
            SET `status` = :status , 
                `approved_sailing_date` = :approved_sailing_date,
                `approved_return_date` = :approved_return_date
            WHERE `id` = :id";
        $this->db->query($query);
        $this->db->bind('id', $id);
        $this->db->bind('status', $status);
        $this->db->bind('approved_sailing_date', $approved_sailing_date);
        $this->db->bind('approved_return_date', $approved_return_date);
        $this->db->execute();
    }

}