<?php
require 'includes/Database.php';
require 'includes/Instructor.php';

if (isset($_GET['ficha_id'])) {
    $ficha_id = $_GET['ficha_id'];
    $instructor = new Instructor();
    $aprendices = $instructor->getAprendices($ficha_id);
    echo json_encode($aprendices);
}
?>
