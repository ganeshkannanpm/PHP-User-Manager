<?php
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';

    if (!empty($name) && !empty($email))  {
        $db = new Database();
        $conn = $db->connect();

        $query = "INSERT INTO users (name, email, phone) VALUES (:name, :email, :phone)";
        $stmt = $conn->prepare($query);

        try {
            $stmt->execute([
                ':name' => $name,
                ':email' => $email,
                ':phone' => $phone
            ]);
            echo json_encode(['status' => 'success', 'message' => 'User added successfully']);
        } catch (PDOException $e) {
            echo json_encode(['status' => 'error', 'message' => 'Email must be unique!']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Name and email are required']);
    }
}
?>
