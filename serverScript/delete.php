<?php
include('class/Database.php');
$db = new Database();
$db->connect();
$db->delete('CRUDClass','id=5');  // Table name, WHERE conditions
$res = $db->getResult();  
print_r($res);