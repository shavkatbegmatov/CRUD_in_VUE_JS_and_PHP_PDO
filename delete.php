<?php

// connect database
$conn = new PDO("mysql:host=localhost:3306;dbname=crud_in_vue_js_and_php_pdo", "root", "");
// delete the user from database
$sql = "DELETE FROM users WHERE id = :id";
$result = $conn->prepare($sql);
// execute the query
$result->execute([
	":id" => $_POST["id"]
]);
$data = $result->fetchAll();

// send the response back AJAX
echo "Done";
