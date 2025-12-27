<?php
require 'db.php';

$id = (int)$_GET['id'];

$stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$student = $stmt->get_result()->fetch_assoc();

if (!$student) {
    die("Student not found");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $course = $_POST["course"];

    $stmt = $conn->prepare(
        "UPDATE students SET name=?, email=?, course=? WHERE id=?"
    );
    $stmt->bind_param("sssi", $name, $email, $course, $id);
    $stmt->execute();

    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Edit Student</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Edit Student</h2>

<form method="POST">
    <label>Name</label>
    <input type="text" name="name" value="<?= htmlspecialchars($student['name']) ?>" required>

    <label>Email</label>
    <input type="email" name="email" value="<?= htmlspecialchars($student['email']) ?>" required>

    <label>Course</label>
    <input type="text" name="course" value="<?= htmlspecialchars($student['course']) ?>" required>

    <button type="submit">Update</button>
    <a href="index.php">Cancel</a>
</form>

</body>
</html>
