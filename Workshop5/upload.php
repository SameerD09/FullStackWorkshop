<?php
// Include header
require('includes/header.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES['portfolioFile'])) {
        $file = $_FILES['portfolioFile'];

        // ADDED try/catch
        try {
            $uploadResult = uploadPortfolioFile($file);
            echo $uploadResult;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>

<form method="POST" enctype="multipart/form-data" action="upload.php">
    <label for="portfolioFile">Upload Portfolio File (PDF, JPG, PNG):</label><br>
    <input type="file" id="portfolioFile" name="portfolioFile"><br><br>
    <input type="submit" value="Upload">
</form>

<?php
// Include footer
require('includes/footer.php');

function uploadPortfolioFile($file) {
    $allowedTypes = ['pdf', 'jpg', 'jpeg', 'png'];
    $maxSize = 2 * 1024 * 1024;  // 2MB

    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];

    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    // CHANGED returns to throws (ONLY so try/catch is meaningful)
    if ($fileError !== UPLOAD_ERR_OK) {
        throw new Exception("Error uploading file.");
    }

    if (!in_array($fileExt, $allowedTypes)) {
        throw new Exception("Invalid file type. Only PDF, JPG, PNG are allowed.");
    }

    if ($fileSize > $maxSize) {
        throw new Exception("File is too large. Maximum size is 2MB.");
    }

    $newFileName = "portfolio_" . time() . "." . $fileExt;
    $uploadDir = 'uploads/';

    if (!is_dir($uploadDir)) {
        $created = mkdir($uploadDir, 0777, true);
        if ($created === false) {
            throw new Exception("Error creating upload directory.");
        }
    }

    if (move_uploaded_file($fileTmpName, $uploadDir . $newFileName)) {
        return "File uploaded successfully!";
    } else {
        throw new Exception("Error moving the file.");
    }
}
?>