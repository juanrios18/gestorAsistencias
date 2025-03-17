<?php

class SuperAdmin
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function createRegional($name)
    {
        $stmt = $this->db->prepare("INSERT INTO regionales (name) VALUES (?)");
        $stmt->bind_param("s", $name);
        return $stmt->execute();
    }

    public function createCentro($name, $regional_id)
    {
        $stmt = $this->db->prepare("INSERT INTO centros (name, regional_id) VALUES (?, ?)");
        $stmt->bind_param("si", $name, $regional_id);
        return $stmt->execute();
    }

    public function getRegionales()
    {
        $result = $this->db->query("SELECT * FROM regionales");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getCentros()
    {
        $query = "SELECT c.*, r.name as regional_name FROM centros c 
                  JOIN regionales r ON c.regional_id = r.id";
        $result = $this->db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}