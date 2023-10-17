<?php

// Connect to the MySQL database
$db = mysqli_connect('localhost', 'root', '', 'izreal4life');

// Check if the connection was successful
if ($db === false) {
    echo 'Error connecting to the database.';
    exit;
}

// Get the form data from the $_POST variable
$email = $_POST['email'];

// Sanitize the form data
$email = mysqli_real_escape_string($db, $email);

// Check if the email already exists in the database
$checkEmailQuery = "SELECT email FROM user WHERE email = '$email'";
$checkEmailResult = mysqli_query($db, $checkEmailQuery);

if (mysqli_num_rows($checkEmailResult) > 0) {
    echo 'This email already exists in the database.';
} else {
    // Create an SQL INSERT statement to insert the form data into the database
    $insertEmailQuery = "INSERT INTO user (email) VALUES ('$email')";

    // Execute the SQL INSERT statement for the email
    $insertEmailResult = mysqli_query($db, $insertEmailQuery);

    if ($insertEmailResult === false) {
        echo 'Error inserting email data into the database.';
    } else {
        header ( 'Location: index2.html');
    }
}

if (isset($_POST['submit'])) {
    // Handle the uploaded file
    if ($_FILES['fileToUpload']['error'] === UPLOAD_ERR_OK) {
        // Get the uploaded file data
        $fileData = file_get_contents($_FILES['fileToUpload']['tmp_name']);
        $fileName = mysqli_real_escape_string($db, basename($_FILES['fileToUpload']['name']));

        // Check if the file already exists in the database
        $checkQuery = "SELECT * FROM files WHERE file_name = '$fileName'";
        $checkResult = mysqli_query($db, $checkQuery);

        if (mysqli_num_rows($checkResult) > 0) {
            echo "File with the same name already exists in the database.";
        } else {
            // Save the file to your computer
            $computerDestination = 'C:\xampp\htdocs\registration\uploads' . $fileName;
            file_put_contents($computerDestination, $fileData);

            // Save the file data to your database
            $fileData = $db->real_escape_string($fileData); // Sanitize the data
            $sql = "INSERT INTO user (file_data, file_name) VALUES ('$fileData', '$fileName')";
            $result = mysqli_query($db, $sql);

            if ($result) {
                header ( 'Location: index2.html');
            } else {
                echo "Error uploading file to the database.";
            }
        }
    } else {
        echo "File upload error: " . $_FILES['fileToUpload']['error'];
    }
}

// Close the connection to the MySQL database
mysqli_close($db);