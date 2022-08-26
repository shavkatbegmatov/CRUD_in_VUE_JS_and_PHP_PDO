<?php

// connect database
$conn = new PDO("mysql:host=localhost:3306;dbname=crud_in_vue_js_and_php_pdo", "root", "");
// update user name and email using his unique ID
$sql = "UPDATE users SET name = :name, email = :email WHERE id = :id";
$result = $conn->prepare($sql);
// execute the query
$result->execute([
	":name" => $_POST["name"],
	":email" => $_POST["email"],
	":id" => $_POST["id"],

]);

// get the updated record
$sql = "SELECT * FROM users WHERE id = :id";
$result = $conn->prepare($sql);
$result->execute(array(
	":id" => $_POST["id"]
));
$data = $result->fetch();

// send the updated record back to AJAX
echo json_encode($data);