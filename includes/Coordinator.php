<?php

class Coordinator {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function createProgram($name) {
        $stmt = $this->db->prepare("INSERT INTO programas (name) VALUES (?)");
        $stmt->bind_param("s", $name);
        return $stmt->execute();
    }

    public function createAmbiente($name) {
        $stmt = $this->db->prepare("INSERT INTO ambientes (name) VALUES (?)");
        $stmt->bind_param("s", $name);
        return $stmt->execute();
    }

    public function createFicha($programa_id, $ambiente_id, $name) {
        $stmt = $this->db->prepare("INSERT INTO fichas (programa_id, ambiente_id, name) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $programa_id, $ambiente_id, $name);
        return $stmt->execute();
    }

    public function createInstructor($username, $password) {
        $user = new User();
        return $user->register($username, $password, 'instructor');
    }

    public function getProgramas() {
        $result = $this->db->query("SELECT * FROM programas");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAmbientes() {
        $result = $this->db->query("SELECT * FROM ambientes");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function getReportes() {
        $query = "
            SELECT a.name AS aprendiz_name, COUNT(*) AS faltas
            FROM asistencias AS asi
            JOIN aprendices AS a ON asi.aprendiz_id = a.id
            WHERE asi.asistio = 0
            GROUP BY a.id
            HAVING COUNT(*) > 3
        ";
        $result = $this->db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}