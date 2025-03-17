<?php

class Coordinator
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function createProgram($name)
    {
        $stmt = $this->db->prepare("INSERT INTO programas (name) VALUES (?)");
        $stmt->bind_param("s", $name);
        return $stmt->execute();
    }

    public function createAmbiente($name)
    {
        $stmt = $this->db->prepare("INSERT INTO ambientes (name) VALUES (?)");
        $stmt->bind_param("s", $name);
        return $stmt->execute();
    }

    public function createFicha($programa_id, $ambiente_id, $name)
    {
        $stmt = $this->db->prepare("INSERT INTO fichas (programa_id, ambiente_id, name) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $programa_id, $ambiente_id, $name);
        return $stmt->execute();
    }

    public function createInstructor($username, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO users (username, password, role) VALUES (?, ?, 'instructor')";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$username, $hashedPassword]);
    }
    public function createAprendiz($name, $ficha_id)
    {
        $stmt = $this->db->prepare("INSERT INTO aprendices (name, ficha_id) VALUES (?, ?)");
        $stmt->bind_param("si", $name, $ficha_id);
        return $stmt->execute();
    }
    public function getFichas()
    {
        $result = $this->db->query("SELECT * FROM fichas");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getProgramas()
    {
        $result = $this->db->query("SELECT * FROM programas");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAmbientes()
    {
        $result = $this->db->query("SELECT * FROM ambientes");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function getReportes()
    {
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
    public function getReportesPorFicha($ficha_id) {
        $stmt = $this->db->prepare("
            SELECT a.id AS aprendiz_id, a.name AS aprendiz_name, 
                                 COUNT(CASE WHEN asis.asistio = 0 THEN 1 END) AS faltas
                          FROM aprendices a
                          LEFT JOIN asistencias asis ON a.id = asis.aprendiz_id
                          WHERE a.ficha_id = ?
                          GROUP BY a.id, a.name;
        ");

        if (!$stmt) {
            die("Error en la consulta: " . $this->db->error);
        }

        $stmt->bind_param("i", $ficha_id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
