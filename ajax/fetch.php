<?php
require_once '../config/db.php';

$db = new Database();
$conn = $db->connect();

$query = "SELECT * FROM users ORDER BY id DESC";
$stmt = $conn->prepare($query);
$stmt->execute();

$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>#ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Created</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php if (count($users) > 0): ?>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?php htmlspecialchars($user['id']) ?></td>
                <td><?php htmlspecialchars($user['name']) ?></td>
                <td><?php htmlspecialchars($user['email']) ?></td>
                <td><?php htmlspecialchars($user['phone']) ?></td>
                <td><?php date('d M Y, h:i A', strtotime($user['created_at'])) ?></td>
                <td>
                    <button class="btn btn-sm btn-warning editBtn" data-id="<?php $user['id'] ?>">Edit</button>
                    <button class="btn btn-sm btn-danger deleteBtn" data-id="<?php $user['id'] ?>">Delete</button>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr><td colspan="6" class="text-center">No users found.</td></tr>
    <?php endif; ?>
    </tbody>
</table>
