<?php

class User
{
    private Database $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function retrieveByAccount($account): mixed
    {
        $query = 'SELECT * FROM `users` WHERE `account`=:account';
        $this->db->query($query);
        $this->db->bind(':account', $account);
        return $this->db->getSingle();
    }
}