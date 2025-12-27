<?php
// Include header
require('includes/header.php');

// Read students.txt and display
$studentsFile = "students.txt";
if (file_exists($studentsFile)) {
    $students = file($studentsFile, FILE_IGNORE_NEW_LINES);
    foreach ($students as $student) {
        list($name, $email, $skills) = explode(", ", $student);

        // ONLY CHANGE: show skills as an array clearly
        echo "<p><strong>Name:</strong> $name <br><strong>Email:</strong> $email <br><strong>Skills:</strong> " .
             json_encode(explode(", ", $skills)) . "</p>";
    }
} else {
    echo "No student data available.";
}

?>

<?php
// Include footer
require('includes/footer.php');
?>