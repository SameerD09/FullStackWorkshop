<?php
require 'db.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $course = trim($_POST["course"]);

    if ($name && $email && $course) {
        $stmt = $conn->prepare(
            "INSERT INTO students (name, email, course) VALUES (?, ?, ?)"
        );
        $stmt->bind_param("sss", $name, $email, $course);
        $stmt->execute();
        header("Location: index.php");
        exit;
    } else {
        $error = "All fields are required.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Add Student</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Add Student</h2>

<?php if ($error): ?>
    <div class="error"><?= $error ?></div>
<?php endif; ?>

<form method="POST">
    <label>Name</label>
    <input type="text" name="name" required>

    <label>Email</label>
    <input type="email" name="email" required>

    <label>Course</label>
    <input type="text" name="course" required>

    <button type="submit">Save</button>
    <a href="index.php">Cancel</a>
</form>

</body>
</html>
