<?php

// Connect to the MySQL database
$db = mysqli_connect('localhost', 'root', '', 'izreal4life');

// Check if the connection was successful
if ($db === false) {
    echo 'Error connecting to the database.';
} else {
    echo '';
}

// Get the form data from the $_POST variable
$email = $_POST['email'];

// Sanitize the form data
$email = mysqli_real_escape_string($db, $email);

// Create an SQL INSERT statement to insert the form data into the database
$sql = "INSERT INTO users (email) VALUES ('$email')";

// Execute the SQL INSERT statement
$result = mysqli_query($db, $sql);

// Check if the insert was successful
if ($result === false) {
    echo 'Error inserting data into the database.';
} else {
    echo 'Data inserted successfully.';
}

// Close the connection to the MySQL database
mysqli_close($db);

?>
