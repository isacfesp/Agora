<?php
require 'fetch_contactos.php';

$start = $_GET['start'] ?? null;
$end = $_GET['end'] ?? null;

$data = fetchContactos($start, $end);

echo json_encode($data);
