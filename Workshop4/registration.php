<?php
// Initialize variables
$name = $email = $password = $confirmPassword = "";
$nameErr = $emailErr = $passwordErr = $confirmPasswordErr = $successMsg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Validate form data
    $isValid = true;

    // Validate name
    if (empty($name)) {
        $nameErr = "Name is required.";
        $isValid = false;
    }

    // Validate email
    if (empty($email)) {
        $emailErr = "Email is required.";
        $isValid = false;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format.";
        $isValid = false;
    }

    // Validate password
    if (empty($password)) {
        $passwordErr = "Password is required.";
        $isValid = false;
    } elseif (strlen($password) < 8) {
        $passwordErr = "Password must be at least 8 characters.";
        $isValid = false;
    } elseif (!preg_match('/[A-Za-z]/', $password) || !preg_match('/\d/', $password)) {
        $passwordErr = "Password must contain both letters and numbers.";
        $isValid = false;
    }

    // Validate confirm password
    if ($password !== $confirmPassword) {
        $confirmPasswordErr = "Passwords do not match.";
        $isValid = false;
    }

    // If validation is successful, proceed with registration
    if ($isValid) {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Prepare user data
        $userData = [
            'name' => $name,
            'email' => $email,
            'password' => $hashedPassword
        ];

        // Read existing users data from users.json
        $usersData = [];
        if (file_exists('users.json')) {
            $jsonData = file_get_contents('users.json');
            $usersData = json_decode($jsonData, true);
        }

        // Add new user to users data
        $usersData[] = $userData;

        // Write updated data back to users.json
        if (file_put_contents('users.json', json_encode($usersData, JSON_PRETTY_PRINT))) {
            $successMsg = "Registration successful!";
        } else {
            $successMsg = "Error occurred while saving data.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
</head>
<body>
    <h2>User Registration</h2>

    <!-- Display success message -->
    <?php if ($successMsg) : ?>
        <div style="color: green;">
            <?php echo $successMsg; ?>
        </div>
    <?php endif; ?>

    <!-- Registration Form -->
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div>
            <label for="name">Name: </label>
            <input type="text" id="name" name="name" value="<?php echo $name; ?>">
            <span style="color: red;"><?php echo $nameErr; ?></span>
        </div>

        <div>
            <label for="email">Email: </label>
            <input type="text" id="email" name="email" value="<?php echo $email; ?>">
            <span style="color: red;"><?php echo $emailErr; ?></span>
        </div>

        <div>
            <label for="password">Password: </label>
            <input type="password" id="password" name="password">
            <span style="color: red;"><?php echo $passwordErr; ?></span>
        </div>

        <div>
            <label for="confirmPassword">Confirm Password: </label>
            <input type="password" id="confirmPassword" name="confirmPassword">
            <span style="color: red;"><?php echo $confirmPasswordErr; ?></span>
        </div>

        <div>
            <button type="submit">Register</button>
        </div>
    </form>
</body>
</html>
