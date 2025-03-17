<?php

class Instructor {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function tomarLista($aprendiz_id, $fecha, $asistio) {
        $stmt = $this->db->prepare("INSERT INTO asistencias (aprendiz_id, fecha, asistio) VALUES (?, ?, ?)");
        $stmt->bind_param("isi", $aprendiz_id, $fecha, $asistio);
        return $stmt->execute();
    }

    public function getFichas() {
        $result = $this->db->query("SELECT * FROM fichas");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAprendices($ficha_id) {
        $stmt = $this->db->prepare("SELECT * FROM aprendices WHERE ficha_id = ?");
        $stmt->bind_param("i", $ficha_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}