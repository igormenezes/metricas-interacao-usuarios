<?php
require $_SERVER['DOCUMENT_ROOT'] . 'metricas-interacao-usuarios/classes/models/Interactions.php';

if($_GET['setup'] == 'user' || $_GET['setup'] == 'brand'){
	$interactions = new Interactions();
	$interactions->findData($_GET['setup']);
	$results = $interactions->get($_GET['setup']);

	echo json_encode($results);
}