<?php

// connect database
$conn = new PDO("mysql:host=localhost:3306;dbname=crud_in_vue_js_and_php_pdo", "root", "");
// get all users from database sorted by latest first
$sql = "SELECT * FROM users ORDER BY id DESC";
$result = $conn->prepare($sql);
// execute the query
$result->execute([]);
$data = $result->fetchAll();

// send all records fetched back to AJAX
echo json_encode($data);
