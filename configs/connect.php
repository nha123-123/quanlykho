<?php
class connect
{
    private $db;

    public function __construct()
    {
        $this->db = mysqli_connect("localhost", "root", "", "quanlykho");
        mysqli_set_charset($this->db, "utf8");
    }

    public function getConnection()
    {
        return $this->db;
    }
}
