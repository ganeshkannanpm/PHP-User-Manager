<?php
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id    = $_POST['id'] ?? '';
    $name  = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';

    if (!empty($id) && !empty($name) && !empty($email)) {
        $db = new Database();
        $conn = $db->connect();

        $query = "UPDATE users SET name = :name, email = :email, phone = :phone WHERE id = :id";
        $stmt = $conn->prepare($query);

        try {
            $stmt->execute([
                ':name'  => $name,
                ':email' => $email,
                ':phone' => $phone,
                ':id'    => $id
            ]);
            echo json_encode(['status' => 'success', 'message' => 'User updated successfully']);
        } catch (PDOException $e) {
            echo json_encode(['status' => 'error', 'message' => 'Email must be unique!']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'All fields required']);
    }
}
?>
