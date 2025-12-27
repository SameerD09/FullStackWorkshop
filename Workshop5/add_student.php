<?php
// Include header
require('includes/header.php');

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = formatName($_POST['name']);
    $email = $_POST['email'];
    $skills = cleanSkills($_POST['skills']);
    
    // Validate email
    if (!validateEmail($email)) {
        echo "Invalid email format.";
    } else {
        // Save student info with try/catch (ADDED)
        try {
            saveStudent($name, $email, $skills);
            echo "Student information saved.";
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>

<form method="POST" action="add_student.php">
    <label for="name">Name:</label><br>
    <input type="text" id="name" name="name"><br><br>
    
    <label for="email">Email:</label><br>
    <input type="email" id="email" name="email"><br><br>
    
    <label for="skills">Skills (comma separated):</label><br>
    <input type="text" id="skills" name="skills"><br><br>
    
    <input type="submit" value="Submit">
</form>

<?php
// Include footer
require('includes/footer.php');

// Custom Functions

function formatName($name) {
    return ucfirst(strtolower(trim($name)));
}

function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function cleanSkills($string) {
    return explode(",", $string);
}

function saveStudent($name, $email, $skillsArray) {
    $studentData = "$name, $email, " . implode(", ", $skillsArray) . "\n";
    $result = file_put_contents("students.txt", $studentData, FILE_APPEND);

    // ADDED (so try/catch actually catches something)
    if ($result === false) {
        throw new Exception("Could not write to students.txt");
    }
}
?>