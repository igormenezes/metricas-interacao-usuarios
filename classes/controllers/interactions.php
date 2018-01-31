<?php
require $_SERVER['DOCUMENT_ROOT'] . 'metricas-interacao-usuarios/classes/models/Interactions.php';

$interactions = new Interactions();
$interactions->findData();
$users = $interactions->get();

echo json_encode($users);