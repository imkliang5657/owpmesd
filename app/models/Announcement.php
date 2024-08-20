<?php

class Announcement
{
    private Database $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function retrieveAll(): bool|array
    {
        $query = '
            SELECT 
                `announcements`.`id`,`title`, `content`, `is_link`, `updated_at`, `organization`
            FROM `announcements`';
        $this->db->query($query);
        return $this->db->getAll();
    }

    public function retrieveByCondition($keyWord, $organization, $startDate, $endDate)
    {
        $query = "
            SELECT 
                `announcements`.`id`,`title`, `content`, `is_link`, `updated_at`,
                `organization`
            FROM `announcements`
            WHERE (:keyWord IS NULL OR `announcements`.`title` LIKE concat('%', :keyWord, '%'))
            AND (:organization IS NULL OR `announcements`.`organization` = :organization)
            AND (:startDate IS NULL OR `announcements`.`updated_at` BETWEEN :startDate AND :endDate)";
        $this->db->query($query);
        $this->db->bind('keyWord', $keyWord);
        $this->db->bind('organization', $organization);
        $this->db->bind('startDate', $startDate);
        $this->db->bind('endDate', $endDate);
        return $this->db->getAll();
    }

    public function retrieveById($id)
    {
        $query = "
            SELECT 
                `announcements`.`id`,`title`, `content`, `is_link`, `announcements`.`updated_at`, `organization`,
                `announced_files`.`name` as `file_name`
            FROM `announcements`
            LEFT JOIN `announced_files` ON `announced_files`.`announcement_id` = announcements.id
            WHERE `announcements`.`id` = :id";
        $this->db->query($query);
        $this->db->bind('id', $id);
        return $this->db->getSingle();
    }

    public function retrieveAllOrganization()
    {
        $query = "SELECT `organization` as `name` FROM `announcements` GROUP BY `organization`";
        $this->db->query($query);
        return $this->db->getAll();
    }

    public function update($id, $title, $content, $is_link, $organization)
    {
        $query = "UPDATE `announcements` 
            SET `title` = :title , 
                `content` = :content,
                `is_link` = :is_link,
                `organization` = :organization
            WHERE `id` = :id";
        $this->db->query($query);
        $this->db->bind('id', $id);
        $this->db->bind('title', $title);
        $this->db->bind('content', $content);
        $this->db->bind('is_link', $is_link);
        $this->db->bind('organization', $organization);
        return $this->db->getAll();
    }

    public function delete($id)
    {
        $query = "DELETE FROM `announcements` WHERE `id` = :id";
        $this->db->query($query);
        $this->db->bind('id', $id);
        $this->db->execute();
    }

    public function create($title, $content, $is_link, $organization)
    {
        $query = "INSERT INTO `announcements` (`title`, `content`, `is_link`, `organization`, `announcer_id`)
                    VALUES (:title, :content, :is_link, :organization, :announcer_id)";
        $this->db->query($query);
        $this->db->bind('title', $title);
        $this->db->bind('content', $content);
        $this->db->bind('is_link', $is_link);
        $this->db->bind('organization', $organization);
        $this->db->bind('announcer_id', $_SESSION['id']);
        $this->db->execute();
    }
}