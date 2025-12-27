<?php
require 'db.php';
$result = $conn->query("SELECT * FROM students ORDER BY id ASC");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Student List</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="top">
    <h2>Student List</h2>
    <a class="button" href="add.php">+ Add Student</a>
</div>

<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Course</th>
        <th>Actions</th>
    </tr>

    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['course']) ?></td>
            <td>
                <a class="button" href="edit.php?id=<?= $row['id'] ?>">Edit</a>
                <a class="button danger"
                   href="delete.php?id=<?= $row['id'] ?>"
                   onclick="return confirm('Delete this student?');">
                   Delete
                </a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

</body>
</html>
