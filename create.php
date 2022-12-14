<?php

// connect database
$conn = new PDO("mysql:host=localhost:3306;dbname=crud_in_vue_js_and_php_pdo", "root", "");
// prepare insert statement
$sql = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
$result = $conn->prepare($sql);
// execute the query
$result->execute([
    ":name" => $_POST["name"],
    ":email" => $_POST["email"],
    // encrypt password in hash
    ":password" => password_hash($_POST["password"], PASSWORD_DEFAULT),
]);


// get the latest record inserted
$sql = "SELECT * FROM users WHERE id = :id";
$result = $conn->prepare($sql);
$result->execute(array(
    ":id" => $conn->lastInsertId()
));
$data = $result->fetch();

// send the newly inserted record back to AJAX
echo json_encode($data);