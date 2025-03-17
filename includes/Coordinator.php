<?php

class Coordinator
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function createProgram($name, $centro_id)
    {
        $stmt = $this->db->prepare("INSERT INTO programas (name, centro_id) VALUES (?, ?)");
        $stmt->bind_param("si", $name, $centro_id);
        return $stmt->execute();
    }

    public function createAmbiente($name, $centro_id)
    {
        $stmt = $this->db->prepare("INSERT INTO ambientes (name, centro_id) VALUES (?, ?)");
        $stmt->bind_param("si", $name, $centro_id);
        return $stmt->execute();
    }

    public function createFicha($programa_id, $ambiente_id, $name)
    {
        $stmt = $this->db->prepare("INSERT INTO fichas (programa_id, ambiente_id, name) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $programa_id, $ambiente_id, $name);
        return $stmt->execute();
    }

    public function createInstructor($username, $email, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, 'instructor')");
        $stmt->bind_param("sss", $username, $email, $hashedPassword);
        return $stmt->execute();
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

    public function getCentros()
    {
        $result = $this->db->query("SELECT * FROM centros");
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
            SELECT 
                a.id AS aprendiz_id, 
                a.name AS aprendiz_name,
                COALESCE(SUM(CASE WHEN asis.asistio = 0 THEN 1 ELSE 0 END), 0) AS faltas
            FROM 
                aprendices a
            LEFT JOIN 
                asistencias asis ON a.id = asis.aprendiz_id
            WHERE 
                a.ficha_id = ?
            GROUP BY 
                a.id, a.name
        ");
    
        if (!$stmt) {
            die("Error en la consulta: " . $this->db->error);
        }
    
        $stmt->bind_param("i", $ficha_id);
        $stmt->execute();
        $result = $stmt->get_result();
    
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function getProgramasByCentro($centro_id)
{
    $stmt = $this->db->prepare("SELECT * FROM programas WHERE centro_id = ?");
    $stmt->bind_param("i", $centro_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

public function getAmbientesByCentro($centro_id)
{
    $stmt = $this->db->prepare("SELECT * FROM ambientes WHERE centro_id = ?");
    $stmt->bind_param("i", $centro_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

public function getCentroById($centro_id)
{
    $stmt = $this->db->prepare("SELECT * FROM centros WHERE id = ?");
    $stmt->bind_param("i", $centro_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}
}